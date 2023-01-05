<?php
namespace app\home\controller;
use \think\Request;
use \think\Log;
use \think\Cookie;
use neco\Wechat\EasyWeChat;

class Index extends Home
{
    private $layout = 'index/layout';
    private $openId = '';
    private $device_number = '';
    protected $action_no_wx = ['debug','check','notify_url','oauth_callback'];

    public function _initialize(){
        if(in_array(request()->action(), $this->action_no_wx)){
            return true;
        }else{
            $this->openId = API('Wechat')->init();
            if(!IS_AJAX)    
                $this->device_number = API('Coffee')->init_device_info(I('device_number'),$this->openId);
            API('Coffee')->update_user($this->openId,$this->device_number);
        }
        if( !IS_AJAX ){
            // 故障禁止订单
            $www['number'] = $this->device_number;
            $device = M('think_device',null)->where($www)->find();
            if(!$device['status'] || !$device['is_online']){
                echo "<h1>当前设备不可使用，请稍后再来！</h1>";
                exit;
            }
            $getRes = API('Coffee')->get_device_trouble_list();
            foreach($getRes['data'] as $v){
                if($v['device_id'] != $device['id'])
                continue;
                if($v['troublewater'] || $v['troublepump'] || $v['troubletemp'] || $v['troublehot'] || $v['troubleunknow'] || $v['troublecup']){
                    echo "<h1>当前设备材料不足，请稍后再来！</h1>";
                    exit;
                }
            }
            
            if($_SERVER['SERVER_ADDR'] != '127.0.0.1'){
                $link = $_SERVER['REQUEST_URI'];
                if(S(md5($link))){
                    echo S(md5($link));
                    exit;
                }
            }
            parent::_initialize();
            $request = Request::instance();
            $this->assign('action_name',$request->action());
            $this->assign('layout',$this->layout);
            if(is_wap())
                $this->assign('is_wap',1);
            $this->assign('meta_title', C('WEB_SITE_TITLE'));
            // 分享jssdk
            $js = Easywechat::js();
            $this->assign('js', $js);
            $share = API('Coffee')->get_share_info($this->device_number);
            $this->assign('share', $share);
            
        }
    }
    
    // 授权回调
    function oauth_callback(){
        API('Wechat')->oauth_callback();
    }

    // 支付回调
    function notify_url(){
        S('front_access',1,10); // 接口权限处理
        $xmlData = file_get_contents('php://input');
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        API('Coffee')->pay_ok($data['out_trade_no'],$data);
        S('front_access',null);
    }

    // 微信接口配置URL
    public function check(){
        API('Wechat')->check();
    }

    public function output_cache($tpl){
        // 10秒缓存
        $html = $this->fetch($tpl);
        if($this->openId)
        S(md5($_SERVER['REQUEST_URI'].$this->openId),$html,10);
        else
        S(md5($_SERVER['REQUEST_URI']),$html,10);
        echo $html;
    }

    public function debug(){
        // $this->output_cache('index/order');
        // $getRes = API('Coffee')->get_device_tune(76);
        // dump($getRes);
        // 支付完成
        // API('Coffee')->pay_ok(72);

        // $getRes = API('Wechat')->pay_back('oMmncweQIjPlbsSYVN3-3gOSsaSI', 30);
        // dump($getRes);
        // exit;

        $model = new \weixin\WeixinBank([]);
        $bank_no = '6225211605066066';
        $true_name = '高鹏';
        $bank_code = '1004';
        $amount = 10;
        $getRes = API('Wechat')->pay_back_card($bank_no, $true_name, $bank_code, $amount);
        dump($getRes);

        // API('Coffee')->_recount_user_money(9);

    }

    public function index(){
        S('front_access',1,10); // 接口权限处理
        // 获得设备通道列表
        $getRes = API('Coffee')->get_device_tune('',$this->device_number,['status'=>1]);
        $this->assign('list', $getRes['data']);
        // 获得广告列表
        $getRes = API('Coffee')->get_advertise_by_shop($this->device_number);
        $this->assign('ads_list', $getRes['data']);
        $this->output_cache('index');
        S('front_access',null);
    }

    public function my(){
        S('front_access',1,10); // 接口权限处理
        $w15w['open_id'] = $this->openId;
        $userinfo = M('cf_customer',null)->where($w15w)->find();
        // $userinfo = Easywechat::user()->get($this->openId);
        $this->assign('userinfo', $userinfo);
        if(I('list_type')){
            if(I('list_type') == 'coupon')
                $type_name = '优惠券';
            if(I('list_type') == 'order')
                $type_name = '订单';
            if(I('list_type') == 'kudou')
                $type_name = '酷豆';
            $this->assign('type_name', $type_name);
            // 我的优惠券
            $ww2w['open_id'] = $this->openId;
            $getRes = API('Coffee')->customer_list($ww2w);
            $customer = $getRes['data'][0];
            foreach($customer['coupon_list'] as &$v){
                $v['status_name'] = '暂不可用';
                $v['status_style'] = 'background-color: #eb6e8e;';
                $v['status_time'] = '日期:'.date('m/d',$v['start_time']);
                $v['status_url'] = '#';
                if($v['is_used']){
                    // 订单
                    $www['customer_coupon_id'] = $v['id'];
                    $order = M('cf_order',null)->where($www)->find();
                    $notify_content = \unserialize($order['notify_content']);
                    $v['status_name'] = '已使用';
                    $v['status_style'] = 'background-color: #ccc;';
                    // $v['status_time'] = '日期:'.date('m/d',$notify_content['time_end']);
                    $v['status_time'] = '日期:'.date('m/d',strtotime($v['create_time']));
                }
                elseif($v['end_time'] < time() ){
                    $v['status_name'] = '已过期';
                    $v['status_style'] = 'background-color: #ccc;';
                    $v['status_time'] = '截止:'.date('m/d',$v['end_time']);
                }elseif($v['start_time'] < time()){
                    $v['status_name'] = '立即使用';
                    $v['status_style'] = 'background-color: #6bba2d;';
                    $v['status_url'] = '/';
                }
            }

            $this->assign('coupon_list', $customer['coupon_list']);
            // 订单
            $ww2w['open_id'] = $this->openId;
            $ww2w['is_pay'] = 1;
            $order_list = M('cf_order',null)->where($ww2w)->order('id desc')->select();
            foreach($order_list as &$v){
                $tune_content = \unserialize($v['tune_content']);
                $v['tune_content'] = $tune_content;
                $v['status_name'] = '已支付';
                $v['status_style'] = 'background-color: #6bba2d;';
                $v['status_time'] = '日期:'.date('m/d',strtotime($v['create_time']));
            }
            $this->assign('order_list', $order_list);
            // 酷豆
            $ww5w['open_id'] = $this->openId;
            $ww5w['status'] = 1;
            $bean_log = M('cf_bean_record',null)->where($ww5w)->order('id desc')->select();
            $order_list = M('cf_order',null)->select();
            foreach($order_list as $v){
                $v['tune_content'] = unserialize($v['tune_content']);
                $order_list_kv[$v['order_id']] = $v;
            }
            foreach($bean_log as &$v){
                $v['order_info'] = $order_list_kv[$v['order_id']];
                $v['status_name'] = '增加'.$v['bean_num'];
                $v['status_style'] = 'background-color: #6bba2d;';
                if($v['opt'] == '-'){
                    $v['status_name'] = '减少'.$v['bean_num'];
                    $v['status_style'] = 'background-color: #eb6e8e;';
                }
                $v['status_time'] = '日期:'.date('m/d',strtotime($v['order_info']['create_time']));
            }
            $this->assign('bean_log', $bean_log);
            $this->output_cache('my_infos');
            S('front_access',null);
            exit;
        }
        $this->output_cache('my');
        S('front_access',null);
    }

    // 订单页面
    public function order(){
        S('front_access',1,10); // 接口权限处理
        if( IS_AJAX ){
            $tune_id = I('tune_id');
            $my_coupon_id = I('my_coupon_id')?:0;
            $use_bean = I('use_bean')?:0;
            $is_half = I('is_half')?:0;
            $free_code = I('free_code')?:0;
            $this->load_pay($tune_id,$my_coupon_id,$use_bean,$free_code,$is_half);
            S('front_access',null);
            return;
        }
        // 获得设备通道信息
        $getRes = API('Coffee')->get_device_tune('',$this->device_number,['id'=>I('tune_id'),'status'=>1]);
        if(!$getRes['status']){
            echo $getRes['msg'];
            S('front_access',null);
            exit;
        }
        $tune_info = $getRes['data'][0];
        $this->assign('tune_info', $tune_info);
        // 优惠券信息
        $www['open_id'] = $this->openId;
        $www['status'] = 1;
        $www['is_used'] = 0;
        $www['start_time'] = array('elt',time());
        $www['end_time'] = array('egt',time());
        $coupon_list = M('cf_customer_coupon',null)->where($www)->order('id desc')->select();
        foreach($coupon_list as &$v){
            $v['coupon_content'] = unserialize($v['coupon_content']);
            $device_ids = \explode(',',$v['coupon_content']['device_ids']);
            if($device_ids && in_array($tune_info['device_id'],$device_ids)){
                $new_coupon_list[] = $v;
            }
        }
        $this->assign('coupon_list', $new_coupon_list);
        // 酷豆
        $ww5w['open_id'] = $this->openId;
        $customer = M('cf_customer',null)->where($ww5w)->find();
        $this->assign('bean_num', $customer['bean_num']?:0);
        // 半价判断
        if( $customer['is_half_price'] &&  $tune_info['is_half_price'])
            $is_half_price = 1;
        $this->assign('is_half_price', $is_half_price);
        $this->output_cache('order');
        S('front_access',null);
    }

    // 载入支付代码段
    public function load_pay($tune_id,$my_coupon_id,$use_bean,$free_code,$is_half){
        S('front_access',1,10); // 接口权限处理
        $res['status'] = false;
        $getRes = API('Coffee')->make_order($this->openId,$tune_id,$my_coupon_id,$use_bean,$free_code,$is_half);
        if(!$getRes['status']){
            echo \json_encode($getRes);
            S('front_access',null);
            exit;
        }
        $order_info = $getRes['data'];
        if($order_info['price']==0){
            $res['status'] = true;
            // 支付完成
            API('Coffee')->pay_ok($order_info['order_id']);
            // 如果兑换码，获得兑换码图片
            if($order_info['free_code']){
                $ww5w['code'] = $order_info['free_code'];
                $free_code = M('cf_free_code',null)->where($ww5w)->find();
                $order_info['free_code_img'] = get_cover($free_code['img']);
            }
            $res['data'] = $order_info;
            $res['flag'] = 1;
            echo \json_encode($res);
            S('front_access',null);
            exit;
        }
        // 先下单
        $getRes = API('Coffee')->make_wx_order($this->openId);
        if($getRes['status']){
            // 再支付
            $json = EasyWeChat::payment()->configForPayment($getRes['data']); // 返回 json 字符串，如果想返回数组，传第二个参数 false
            $this->assign('json',$json);
            $html = $this->fetch('order_pay');
            $res['status'] = true;
            $res['data'] = $html;
        }else{
            $res['msg'] = $getRes['msg'];
        }
        echo \json_encode($res);
        S('front_access',null);
        exit;
    }



}
