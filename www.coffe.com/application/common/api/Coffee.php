<?php
namespace app\common\api;
use app\common\api\Base;
use neco\Wechat\EasyWeChat;
use \think\Log;
use nfutil\Page;
use \think\Loader;

class Coffee extends Base
{   

    public $bank = [
        '1002'=>'工商银行',
        '1005'=>'农业银行',
        '1026'=>'中国银行',
        '1003'=>'建设银行',
        '1001'=>'招商银行',
        '1066'=>'邮储银行',
        '1020'=>'交通银行',
        '1004'=>'浦发银行',
        '1006'=>'民生银行',
        '1009'=>'兴业银行',
        '1010'=>'平安银行',
        '1021'=>'中信银行',
        '1025'=>'华夏银行',
        '1027'=>'广发银行',
        '1022'=>'光大银行',
        '4836'=>'北京银行',
        '1056'=>'宁波银行',
        '1024'=>'上海银行',
    ];


    // 支付回调
    function notify_url(){
        Log::write(json_encode(I('')),'log',true);
    }
        
    // 初始化客户
    function init_user_lite($user_info){
        if($user_info['id']){
            $www['open_id'] = $user_info['id'];
            $user = D2('cf_customer')->where($www)->find();
            if($user)
                return false;
            $data['content'] = serialize($user_info);
            $data['create_time'] = time();
            $data['open_id'] = $user_info['id'];
            $data['nickname'] = $user_info['nickname'];
            $data['sex'] = $user_info['original']['sex'];
            $data['headimgurl'] = $user_info['avatar'];
            $data = D2('cf_customer')->create($data);
            // Log::write($data,'log',true);
            if($data)
                D2('cf_customer')->add();
            return true;
        }
        return false;
    }

    // 客户
    function update_user($openId,$device_number){
        if($openId){
            $www['open_id'] = $openId;
            $user = D2('cf_customer')->where($www)->find();
            if(!$user || $user['device_id'])
                return false;
            $data['device_number'] = $device_number;
            $w2ww['number'] = $data['device_number'];
            $device = M('think_device',null)->where($w2ww)->find();
            $data['device_id'] = $device['id'];
            D2('cf_customer')->where($www)->save($data);
            return true;
        }
        return false;
    }

    // 初始化客户
    function init_user($openId,$device_number){
        if($openId){
            $www['open_id'] = $openId;
            $user = D2('cf_customer')->where($www)->find();
            if($user)
                return false;
            $user_info  = EasyWeChat::user()->get($openId); // 必须关注
            if($user_info['openid']){
                foreach($user_info as $k=>$v){
                    $data[$k] = $v;
                }
                $data['content'] = serialize($user_info);
                $data['create_time'] = time();
                $data['device_number'] = $device_number;
                $w2ww['number'] = $data['device_number'];
                $device = M('think_device',null)->where($w2ww)->find();
                $data['device_id'] = $device['id'];
                $data['open_id'] = $openId;
            }
            $data = D2('cf_customer')->create($data);
            if($data)
                D2('cf_customer')->add();
            return true;
        }
        return false;
    }

    // 支付完成
    function pay_ok($order_id,$notify_content=[]){
        $www['order_id'] = $order_id;
        $order = M('cf_order',null)->where($www)->find();
        if($order['is_pay'])
            return true;
        // 退款处理
        $this->pay_back($order['device_id']);
        // 处理优惠券
        $ww2w['id'] = $order['customer_coupon_id'];
        $dd2d['is_used'] = 1;
        $dd2d['use_time'] = date('Y-m-d H:i:s',time());
        M('cf_customer_coupon',null)->where($ww2w)->save($dd2d);
        // 处理酷豆
        $ww5w['open_id'] = $order['open_id'];
        $dd5d['status'] = 1;
        M('cf_bean_record',null)->where($ww5w)->save($dd5d);
        $this->_recount_bean_num($order['open_id']);
        // 处理半价
        $ww6w['open_id'] = $order['open_id'];
        if($order['is_half']){
            $dd6d['is_half_price'] = 0;
        }else
            $dd6d['is_half_price'] = 1;
        M('cf_customer',null)->where($ww6w)->save($dd6d);
        // Log::write(json_encode($dd6d),'log',true);
        // 处理兑换码
        if($order['free_code']){
            $ww9w['code'] = $order['free_code'];
            $dd9d['is_used'] = 1;
            $dd9d['use_time'] = time();
            M('cf_free_code',null)->where($ww9w)->save($dd9d);
        }
        // 完成支付
        $www['order_id'] = $order_id;
        $data['is_pay'] = 1;
        if($notify_content)
            $data['notify_content'] = serialize($notify_content);
        M('cf_order',null)->where($www)->save($data);
        // 生成咖啡机订单
        $tune = unserialize($order['tune_content']);
        $getRes = $this->get_device_tune($tune['device_id']);
        $tune = $getRes['data'][0];
        // 场所信息
        $ww23w['id'] = $tune['device_id'];
        $device = M('think_device',null)->where($ww23w)->find();
        $ww25w['id'] = $tune['shop_id'];
        $shop = M('think_shop',null)->where($ww25w)->find();
        // 数据
        $dd3d['pay_order_id'] = $order_id;
        $dd3d['shop_id'] = $shop['id'];
        $dd3d['device_id'] = $tune['device_id'];
        $dd3d['shop_number'] = $shop['shop_number'];
        $dd3d['goods_type'] = $order['goods_type'];
        $dd3d['status'] = 0;
        $dd3d['opid'] = $order['open_id'];
        $dd3d['refund'] = 0; //退款
        $dd3d['ispay'] = 1;
        $dd3d['created_at'] = date('Y-m-d H:i:s',time());
        $ww3w['open_id'] = $order['open_id'];
        $customer = M('cf_customer',null)->where($ww3w)->find();
        $customer['content'] = \unserialize($customer['content']);
        $dd3d['username'] = $customer['nickname'];
        $dd3d['sex']  = $customer['sex'];
        $dd3d['city'] = $customer['content']['nickname'];
        $dd3d['attention_time'] = $customer['content']['attention_time'];
        M('think_shop_order',null)->add($dd3d);
        // 营收分配
        $this->_make_money_record($order,'+','订单收入');
    }

    function _make_money_record($order,$opt,$opt_type,$pay_info=[]){
        if($order['price'] <= 0 || !$order['price'] )
        return;
        $ww5w['device_id'] = $order['device_id'];
        $user_device = M('cf_user_device',null)->where($ww5w)->find();
        // 记录
        $ddd['uid'] = $user_device['uid'];
        $ddd['open_id'] = $order['open_id'];
        $ddd['order_id'] = $order['id'];
        $ddd['order_content'] = \serialize($order);
        $ddd['opt'] = $opt;
        $ddd['opt_type'] = $opt_type;
        $ddd['pay_money'] = $order['price'];
        $ddd['remark'] = $ddd['opt_type'];
        $ddd['status'] = 1;
        $ddd['pay_content'] = \serialize($pay_info);
        $ddd['payment_no'] = $pay_info['payment_no'];
        $ddd['back_up'] = \serialize($ddd);
        M('cf_user_money_record',null)->add($ddd);
        $this->_recount_user_money($ddd['uid']);
    }

    function _recount_bean_num($open_id){
        $ww5w['open_id'] = $open_id;
        $ww5w['status'] = 1;
        $bean_list = M('cf_bean_record',null)->where($ww5w)->select();
        $bean_num = 0;
        foreach($bean_list as $v){
            if($v['opt'] == '-')
                $bean_num -= $v['bean_num'];
            if($v['opt'] == '+')
                $bean_num += $v['bean_num'];
        }
        $ww6w['open_id'] = $open_id;
        $dd6d['bean_num'] = $bean_num;
        M('cf_customer',null)->where($ww6w)->save($dd6d);
    }

    // 下单
    function make_wx_order($openId){
        $www['open_id'] = $openId;
        $www['is_pay'] = 0;
        $order = M('cf_order',null)->where($www)->find();
        $order['tune_content'] = \unserialize($order['tune_content']);
        // $order_id = 'xxx'.rand(1000,10000).'xxx'.time();
        $res['status'] = false;
        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => $order['tune_content']['title'],
            'detail'           => $order['tune_content']['title'],
            'out_trade_no'     => $order['order_id'],
            'total_fee'        => intval( ($order['price']+0) * 100 ), // 单位：分
            'notify_url'       => 'http://'.$_SERVER['HTTP_HOST'].'/home/index/notify_url',
            'openid'           => $openId, 
        ];
        $order = new \EasyWeChat\Payment\Order($attributes);
        $result = EasyWeChat::payment()->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            $res['status'] = true;
            $res['data'] = $result->prepay_id;
        } else {
            $res['msg'] = '调起支付失败，请稍后尝试';
            Log::write(\json_encode($result),'log',true);
            dump($result);
        }
        return $res;
    }

    // 生成订单
    function make_order($openId,$tune_id,$my_coupon_id=0,$use_bean=0,$free_code='',$is_half=0){
        $res['status'] = false;
        // 关闭旧订单
        $ww4w['open_id'] = $openId;
        $ww4w['is_pay'] = 0;
        M('cf_order',null)->where($ww4w)->delete();
        // 关闭旧酷豆
        $ww7w['open_id'] = $openId;
        $ww7w['status'] = 0;
        M('cf_bean_record',null)->where($ww7w)->delete();
        // 检查
        $www['id'] = $tune_id;
        $tune = M('cf_device_tune',null)->where($www)->find();
        $tune['content'] = \unserialize($tune['content']);
        $price = $tune['price'];
        if(!$price){
            $res['msg'] = '发生异常1';
            echo \json_encode($res);
            exit;
        }
        $data['open_id'] = $openId;
        $data['order_id'] = 'xxx'.rand(1000,10000).'xxx'.time();
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $data['tune_id'] = $tune['id'];
        $data['device_id'] = $tune['device_id'];
        $data['goods_type'] = $tune['goods_type'];
        $data['is_pay'] = 0;
        $data['tune_content'] = \serialize($tune);
        $data['customer_coupon_id'] = 0;
        $data['bean_num'] = 0;
        $data['free_code'] = 0;
        $data['is_half'] = 0;
        // 计算价格
        // 兑换码
        if($free_code){
            // 检查兑换码
            if(!$this->check_free_code($free_code,$tune['content']['device_id'])){
                $res['msg'] = '兑换码无效';
                echo \json_encode($res);
                exit;
            }
            $data['free_code'] = $free_code;
            $price = 0;
        }else{
            // 优惠券
            if($my_coupon_id){
                $ww3w['id'] = $my_coupon_id;
                $my_coupon = M('cf_customer_coupon',null)->where($ww3w)->find();
                if(!$my_coupon){
                    $res['msg'] = '发生异常2';
                    echo \json_encode($res);
                    exit;
                }
                $rebate = $my_coupon['rebate'];
                $price = $price *(intval($rebate)/10);
                $price = floor($price * 100) / 100;
            }
            $data['customer_coupon_id'] = $my_coupon_id;
            // 半价处理
            $ww5w['open_id'] = $openId;
            $customer = M('cf_customer',null)->where($ww5w)->find();
            if($is_half && $customer['is_half_price']){
                $price = $price/2;
                $price = floor($price * 100) / 100;
                $data['is_half'] = 1;
            }
            // 处理酷豆
            $dd5d['open_id'] = $openId;
            $dd5d['order_id'] = $data['order_id'];
            $dd5d['status'] = 0;
            if($use_bean){
                // 减酷豆-准备
                if($price > 0 && $customer['bean_num'] >= $price * 10 ){
                    $dd5d['opt'] = '-';
                    $dd5d['bean_num'] = $price * 10;
                    $dd5d['pay_price'] = 0;
                    M('cf_bean_record',null)->add($dd5d);
                    $price = 0;
                    $data['bean_num'] = $dd5d['bean_num'];
                }
            }
            if($price > 0 ){
                $ww9w['id'] = $tune['device_id'];
                $device = M('think_device',null)->where($ww9w)->find();
                if($device['is_add_bean']){
                    // 加酷豆-准备
                    $dd5d['opt'] = '+';
                    $dd5d['bean_num'] = $price ;
                    $dd5d['pay_price'] = $price;
                    M('cf_bean_record',null)->add($dd5d);
                }
            }
        }
        $data['price'] = $price;
        $data['cut_price'] = $tune['price'] - $price;
        $mode_object = D2('cf_order');
        $data = $mode_object->create($data);
        if ($data) {
            $id = $mode_object->add();
            if ($id !== false) {
                $res['status'] = true;
                $data['id'] = $id;
                $res['data'] = $data;
                return $res;
            }
        }
        $res['msg'] = $mode_object->getError();
        return $res;
    }

    // 设备列表
    function get_device_list($where=[]){
        $res['status'] = true;
        $mode = 'think_device';
        $page_row = 10;
        $map = $where;
        if(!$where['a.id']){
            $keyword = I('keyword', '', 'string');
            $condition = array('like','%'.$keyword.'%');
            $map['a.id|a.number'] = array($condition, $condition,'_multi'=>true);
        }
        //权限
        $map = $this->get_admin_device_map($map,'a.id');
        $data_list = M($mode,null)->alias('a')->field('w.id as s_id,w.*,a.*')->join('think_shop w ON a.shop_id = w.id','LEFT')->page(!empty(I('p'))?I('p'):1, $page_row)->where($map)->order('a.id desc')->select();
        $data_list = _fix_data($data_list);
        // 管理员
        $admin_list = M('nf_admin_user',null)->select();
        foreach($admin_list as $v){
            $admin_list_kv[$v['id']] = $v['username'];
        }
        $device_list = M('cf_user_device',null)->where($www)->select();
        foreach($device_list as $v){
            $device_list_kv[$v['device_id']] = $v['uid'];
        }
        foreach($data_list as &$v){
            // 用户
            $uid = $device_list_kv[$v['id']];
            $v['uid_name'] = $admin_list_kv[$uid];
        }
        $page = new Page(M($mode,null)->alias('a')->join('think_shop w ON a.shop_id = w.id','LEFT')->where($map)->count(), $page_row);
        $res['data'] = $data_list;
        $res['page'] = $page;
        return $res;
    }

    // 设备渠道
    function get_device_tune($device_id='',$device_number='',$where=[]){
        if($device_id){
            $map = ['a.id'=>$device_id];
        }else if($device_number)
            $map = ['a.number'=>$device_number];
        else{
            $res['status'] = false;
            return $res;
        }    
        $getRes = $this->get_device_list($map);
        $device_info = $getRes['data'][0];
        $res['status'] = true;
        $www['device_id'] = $getRes['data'][0]['id'];
        $www = array_merge($www, $where);
        $data_list = M('cf_device_tune',null)->where($www)->order('goods_type asc')->select();
        foreach($data_list as &$v){
            $v = array_merge($device_info,$v);
            $v['content'] = unserialize($v['content']);
            foreach($v['content'] as $kkk=>$vvv){
                if(!$v[$kkk]){
                    $v[$kkk] = $vvv;
                }
            }
        }
        $res['data'] = $data_list;
        return $res;
    }
    
    // 设备渠道编辑
    function edit_tune($post){
        $res['status'] = false;
        $mode_object = D2('CfDeviceTune');
        $post = I('post.');
        $post['content'] = serialize($post) ;
        $data = $mode_object->create($post);
        if ($data) {
            if($data['id'])
                $result = $mode_object->save($data);
            else
                $result = $mode_object->add();
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $url = Cookie('__forward_project_level__')?:U('device_tune_list',['id'=>$post['device_id']]);
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }
    
    // 设备渠道详情
    function get_tune_detail($where=[]){
        $res['status'] = true;
        $data = M('cf_device_tune',null)->where($where)->find();
        $data['content'] = unserialize($data['content']);
        foreach($data['content'] as $k=>$v){
            if(!$data[$k]){
                $data[$k] = $v;
            }
        }
        $res['data'] = $data;
        return $res;
    }

    // 获得店铺
    function get_shop_list($where=[]){
        $list = M('think_shop',null)->where($where)->order('id desc')->select();
        foreach($list as $v){
            $list_kv[$v['id']] = $v['shop_name'];
        }
        $res['data'] = $list_kv;
        return $res;
    }

    // 设备编辑
    function edit_device($post){
        $res['status'] = false;
        $mode_object = D2('think_device');
        $data = $mode_object->create($post);
        $data['device_place'] = $post['device_place'];
        $data['content'] = \serialize($data);
        if ($data) {
            if($data['id']){
                unset($data['number']);
                $result = $mode_object->save($data);
            }
            else
                $result = $mode_object->add();
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $url = Cookie('__forward_project_level__')?:U('device_list');
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }

    // 编辑
    function edit_device_weixin_share($post){
        $res['status'] = false;
        if($post['tpl_id']){
            $www['id'] = $post['tpl_id'];
            $tpl = M('cf_device_weixin_template',null)->where($www)->find();
            unset($tpl['id']);
            foreach($post as $k=>$v){
                // if(!$post[$k])
                if($tpl[$k])
                $post[$k] = $tpl[$k];
            }
        }
        $mode_object = D2('CfDeviceWeixin');
        $data = $mode_object->create($post);
        if ($data) {
            if($data['id'])
                $result = $mode_object->save($data);
            else
                $result = $mode_object->add();
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $url = Cookie('__forward_project_level__')?:U('device_list');
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }
    
    // 编辑
    function get_share_info($device_number){
        $www['number'] = $device_number;
        $device = D2('think_device')->where($www)->find();
        $ww2w['device_id'] = $device['id'];
        $weixin = D2('CfDeviceWeixin')->where($ww2w)->find();
        if(!$weixin){
            $weixin['img_url'] = 'http://pay.zhuhemedia.com/weixin/img/share.jpg';
            $weixin['desc'] = '一键操作，方便快捷';
            $weixin['link'] = 'http://coffee.zhuhemedia.com/home/index/index/device_number/'.$device_number;
            $weixin['title'] = '微饮媒体机';
        }else{
            $weixin['img_url'] = 'http://coffee.zhuhemedia.com/'.get_cover($weixin['img_url']);
            $weixin['img_url'] = str_replace('\\', '', $weixin['img_url']);
        }
        return $weixin;
    }

    // 故障列表
    function get_device_trouble_list(){
        //权限
        $www = $this->get_admin_device_map([],'a.device_id');
        $data_list = M('think_device_trouble',null)->alias('a')->field('w.id as d_id,w.*,a.*')->
            join('think_device w ON a.device_id = w.id','LEFT')->where($www)->order('w.id desc')->select();
        foreach($data_list as &$v){
            $v['troublecup_name'] = $v['troublecup']==0 ?1:0; 
            $v['troublewater_name'] = $v['troublewater']==0 ?1:0; 
            $v['troublepump_name'] = $v['troublepump']==0 ?1:0; 
            $v['troubletemp_name'] = $v['troubletemp']==0 ?1:0; 
        }
        $res['data'] = $data_list;
        return $res;
    }

    public function del_device_trouble($id){
        $map['id'] = $id;
        $dtrouble['troubleWater'] = '0';
        $dtrouble['troublePump'] = '0';
        $dtrouble['troubleTemp'] = '0';
        $dtrouble['troubleCup'] = '0';
        $dtrouble['troubleHot'] = '0';
        $re = M('think_device_trouble',null)->where($map)->save($dtrouble);
        $res['status'] = $re===false?false:true;
        $res['msg'] = '成功';
        return $res;
    }

    public function get_advertise_list($where=[]){
        $res['status'] = true;
        $mode = 'think_advertise';
        $page_row = 10;
        $map = $where;
        if(!$where['id']){
            $keyword = I('keyword', '', 'string');
            $condition = array('like','%'.$keyword.'%');
            $map['id|show_name'] = array($condition, $condition, '_multi'=>true);
        }
        $data_list = M($mode,null)->page(!empty(I('p'))?I('p'):1, $page_row)->where($map)->order('id desc')->select();
        $data_list = _fix_data($data_list);
        foreach($data_list as &$v){
            $v = $this->_get_advertise($v);
            $v['file_img_name'] = get_cover($v['file_img']);
            $v['background_name'] = get_cover($v['background']);
        }
        $page = new Page(M($mode,null)->where($map)->count(), $page_row);
        $res['data'] = $data_list;
        $res['page'] = $page;
        return $res;
    }
    
    // 广告编辑
    function edit_advertise($post){
        $res['status'] = false;
        $mode_object = D2('think_advertise');
        // 图片/视频
        $post['file_name'] = $post['file_media'];
        if($post['type'] == 1){
            $post['file_name'] = $post['file_img'];
        }
        // 类别
        $www['id'] = $post['advertise_class_id'];
        $class = M('think_advertise_class',null)->where($www)->find();
        $post['advertise_class_name'] = $class['name'];
        $post['content'] = \serialize($post);
        if(!$data['id'])
            $post['created_at'] = date('Y-m-d H:i:s',time());
        $data = $mode_object->create($post);
        if ($data) {
            if($data['id'])
                $result = $mode_object->save();
            else{
                $result = $mode_object->add();
            }
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $_pre = '_dev';
                if($post['advertise_class_id'] == '20'){
                    $_pre = '_wx';
                }
                $url = Cookie('__forward_project_level__')?:U('advertise_list'.$_pre,['advertise_class_id'=>$post['advertise_class_id']]);
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }
    
    // 获得广告
    public function get_advertise($www=[]){
        $data = M('think_advertise',null)->where($www)->find();
        if($data){
            $data = $this->_get_advertise($data);
            return $data;
        }
    }

    public function _get_advertise($data){
        $data['content'] = unserialize($data['content']);
        foreach($data['content'] as $k=>$v){
            if(!$data[$k]){
                $data[$k] = $v;
            }
        }
        $data['type_name'] = '视频';
        $data['file_name'] = $data['content']['file_media'];
        if($data['type'] == 1){
            $data['type_name'] = '图片';
            $data['file_name'] = $data['content']['file_img'];
        }
        return $data;
    }

    public function del_advertise($id){
        $res['status'] = true;
        $map['id'] = $id;
        M('think_advertise',null)->where($map)->delete();
        $res['msg'] = '成功';
        return $res;
    }

    // 广告列表
    function advertise_list_device($www=[],$pre){
        return $this->_advertise_list($www,$pre);
    }

    function _advertise_list($www=[],$pre){
        $pre = $pre == '_shop'?'_weixin':$pre;
        $data_list = M('think_advertise'.$pre,null)->where($www)->order('id desc')->select();
        foreach($data_list as $k=>&$v){
            $ad_tmp = $this->get_advertise(['id'=>$v['advertise_id'],'status'=>1]);
            if(!$ad_tmp){
                unset($data_list[$k]);
                continue;
            }
            unset($ad_tmp['id']);
            foreach($ad_tmp as $kkk=>$vvv){
                $v[$kkk] = $vvv;
            }
        }
        $res['data'] = $data_list;
        return $res;
    }


    // 编辑
    function advertise_edit_device($post,$pre){
        $res['status'] = false;
        $mode_object = D2('think_advertise'.$pre);
        if(!$data['id'])
            $post['created_at'] = date('Y-m-d H:i:s',time());
        $data = $mode_object->create($post);
        if ($data) {
            if($data['id'])
                $result = $mode_object->save();
            else{
                $result = $mode_object->add();
            }
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $id = $pre == '_shop'?$post['shop_id']:$post['device_id'];
                $url = Cookie('__forward_project_level__')?:U('advertise_list'.$pre,['id'=>$id]);
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }

    // 场所管理
    function shop_list($where=[]){
        $data_list = M('think_shop',null)->where($www)->order('id desc')->select();
        $res['data'] = $data_list;
        return $res;
    }

    // 通过设备号获得场所
    function get_shop_by_device($device_number){
        $res['status'] = false;
        if(!$device_number){
            $res['msg'] = '请重新扫码购买';
            return $res;
        }
        $www['number'] = $device_number;
        $device = M('think_device',null)->where($www)->find();
        if($device['shop_id']){
            $ww2w['id'] = $device['shop_id'];
            $shop = M('think_shop',null)->where($ww2w)->find();
            $res['status'] = true;
            $res['data'] = $shop;
            return $res;
        }
        $res['msg'] = '该设备已经移除，请关闭';
        return $res;
    }

    // 广告列表-前台
    function get_advertise_by_shop($device_number){
        $getRes = $this->get_shop_by_device($device_number);
        if(!$getRes['status']){
            return $getRes;
        }
        $shop = $getRes['data'];
        $www['shop_id'] = $shop['id'];
        $data_list = M('think_advertise_weixin',null)->where($www)->order('id desc')->select();
        foreach($data_list as $k=>&$v){
            // 条件控制
            $ww3w['id'] = $v['advertise_id'];
            $ww3w['status'] = 1;
            $ww3w['star_time'] = array('elt',date('Y-m-d'));
            $ww3w['end_time'] = array('egt',date('Y-m-d',time()-60*60*24));
            $ad_tmp = $this->get_advertise($ww3w);
            if(!$ad_tmp){
                unset($data_list[$k]);
                continue;
            }
            unset($ad_tmp['id']);
            foreach($ad_tmp as $kkk=>$vvv){
                $v[$kkk] = $vvv;
            }
        }
        $res['data'] = $data_list;
        return $res;
    }

    // 广告列表
    function advertise_list_shop($www=[]){
        return $this->_advertise_list($www,'_weixin');
    }

    // 处理设备信息
    function init_device_info($device_number='',$openId){
        if($device_number){
            $device_number = $device_number?:'2050325030';
            $getRes = $this->get_shop_by_device($device_number);
            if($getRes['status']){
                S('device_number'.$openId,$device_number, 60*60);
                return $device_number;
            }
            echo $getRes['msg'];
        }else{
            if(S('device_number'.$openId)){
                $device_number = S('device_number'.$openId);
                return $device_number;
            }
            echo "<h1>请重新扫码购买！</h1>";
        }
        exit;
    }

    // 生成二维码
    function make_qrcode($url,$png_url){
        Loader::import('phpqrcode.phpqrcode');
        $object = new \QRcode();
        $level=3;
        $size=4;
        $errorCorrectionLevel =intval($level) ;//容错级别
        $matrixPointSize = intval($size);//生成图片大小
        $object->png($url,  $png_url, $errorCorrectionLevel, $matrixPointSize, 2);  
    }

    // 客户列表
    function customer_list($where=[]){
        $res['status'] = true;
        $mode = 'cf_customer';
        $page_row = 10;
        $map = $where;
        if(!$where['id']){
            $keyword = I('keyword', '', 'string');
            $condition = array('like','%'.$keyword.'%');
            $map['id|nickname'] = array($condition, $condition, '_multi'=>true);
        }
        //权限
        $map = $this->get_admin_device_map($map);
        $data_list = M($mode,null)->page(!empty(I('p'))?I('p'):1, $page_row)->where($map)->order('id desc')->select();
        $data_list = _fix_data($data_list);
        foreach($data_list as &$v){
            // 优惠券
            $v['coupon_list'] = $this->get_customer_coupon($v['id']);
            $v['coupon_num'] = count($v['coupon_list']);
        }
        $page = new Page(M($mode,null)->where($map)->count(), $page_row);
        $res['data'] = $data_list;
        $res['page'] = $page;
        return $res;
    }

    // 获得客户优惠券
    function get_customer_coupon($customer_id='',$open_id=''){
        if($customer_id)
            $www['customer_id'] = $customer_id;
        if($open_id)
            $www['open_id'] = $open_id;
        $coupon_list = M('cf_customer_coupon',null)->where($www)->order('id desc')->select();
        foreach($coupon_list as &$v){
            $v['coupon_content'] = \unserialize($v['coupon_content']);
            // 状态
            $v['coupon_status'] = $v['status']?'启用':'未启用';
            // 可用
            $v['is_used_name'] = $v['is_used']?'已使用':'待用';
            if( $v['use_time'])
            $v['use_time_name'] = date('Y-m-d H:i:s',$v['use_time']);
        }
        return $coupon_list;
    }

    // 优惠券编辑
    function coupon_edit($post){
        $res['status'] = false;
        $mode_object = D2('cf_coupon');
        $post['start_time'] = strtotime($post['start_time']);
        $post['end_time'] = strtotime($post['end_time']);
        $post['uid'] = $this->uid;
        $post['device_ids'] = implode(',',$post['device_ids']);
        $data = $mode_object->create($post);
        if ($data) {
            if($data['id']){
                $res['msg'] = '禁止修改';
                $result = false;
                // $result = $mode_object->save();
            }else{
                $result = $mode_object->add();
            }
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $_pre = '_dev';
                if($post['advertise_class_id'] == '20'){
                    $_pre = '_wx';
                }
                $url = Cookie('__forward_project_level__')?:U('coupon_manage');
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }

    // 优惠券列表
    function coupon_list($where=[]){
        $res['status'] = true;
        $mode = 'cf_coupon';
        $page_row = 10;
        $map = $where;
        if(!$where['id']){
            $keyword = I('keyword', '', 'string');
            $condition = array('like','%'.$keyword.'%');
            $map['id|title'] = array($condition, $condition, '_multi'=>true);
        }
        //权限
        if($this->uid != 1){
            $map['uid'] = $this->uid;
        }
        $data_list = M($mode,null)->page(!empty(I('p'))?I('p'):1, $page_row)->where($map)->order('id desc')->select();
        $data_list = _fix_data($data_list);
        $device_list = M('think_device',null)->select();
        foreach($device_list as $v){
            $content = \unserialize($v['content']);
            $device_list_kv[$v['id']] = $content['device_place'].'/'.$v['number'];
        }
        foreach($data_list as &$v){
            $v['start_time_name'] = date('Y-m-d',$v['start_time']);
            $v['end_time_name'] = date('Y-m-d',$v['end_time']);
            $v['device_ids'] = explode(',',$v['device_ids']);
            foreach($v['device_ids'] as $vvv){
                if($v['device_ids_name'])
                $v['device_ids_name'] .= ','.$device_list_kv[$vvv];
                else
                $v['device_ids_name'] = $device_list_kv[$vvv];
            }
        }
        $page = new Page(M($mode,null)->where($map)->count(), $page_row);
        $res['data'] = $data_list;
        $res['page'] = $page;
        return $res;
    }

    public function order_list($where=[]){
        $res['status'] = true;
        $mode = 'cf_order';
        $page_row = 10;
        $map = $where;
        if(!$where['id']){
            $keyword = I('keyword', '', 'string');
            $condition = array('like','%'.$keyword.'%');
            $map['id|order_id'] = array($condition, $condition, '_multi'=>true);
            $map['is_pay'] = 1;
        }
        // 优惠券
        $coupon_list = M('cf_customer_coupon',null)->select();
        foreach($coupon_list as $v){
            $v['coupon_content'] = unserialize($v['coupon_content']);
            $coupon_list_kv[$v['id']] = $v['coupon_content']['title'];
        }
        //权限
        $map = $this->get_admin_device_map($map);
        $data_list = M($mode,null)->page(!empty(I('p'))?I('p'):1, $page_row)->where($map)->order('id desc')->select();
        foreach($data_list as &$v){
            $v['tune_content'] = \unserialize( $v['tune_content']);
            foreach($v['tune_content'] as $kkk=>$vvv){
                if(!$v[$kkk]){
                    $v[$kkk] = $vvv;
                }
            }
            $v['notify_content'] = \unserialize( $v['notify_content']);
            foreach($v['notify_content'] as $kkk=>$vvv){
                if(!$v[$kkk]){
                    $v[$kkk] = $vvv;
                }
            }
            // 客户信息
            $ww12w['open_id'] = $v['open_id'];
            $customer = M('cf_customer',null)->where($ww12w)->find();
            foreach($customer as $kkk=>$vvv){
                if(!$v[$kkk]){
                    $v[$kkk] = $vvv;
                }
            }
            // 优惠券
            $v['coupon_name'] = $coupon_list_kv[$v['customer_coupon_id']]?:0;
            $v['bean_num'] = $v['bean_num']?:0;
            $v['free_code'] = $v['free_code']?:0;
            $v['is_half'] = $v['is_half']?:0;
        }
        $page = new Page(M($mode,null)->where($map)->count(), $page_row);
        $res['data'] = $data_list;
        $res['page'] = $page;
        return $res;
    }

    // 兑换码
    public function check_free_code($code,$device_id){
        $www['device_id'] = $device_id;
        $www['code'] = $code;
        $www['is_used'] = 0;
        $www['start_time'] = array('elt',date('Y-m-d H:i:s',time()));
        $www['end_time'] = array('egt',date('Y-m-d H:i:s',time()));
        $free_code = M('cf_free_code',null)->where($www)->find();
        if($free_code){
            return true;
        }
        return false;
    }
    
    // 兑换码
    public function get_free_code($where=[]){
        $res['status'] = true;
        $mode = 'cf_free_code';
        $page_row = 10;
        $map = $where;
        if(!$where['id']){
            $keyword = I('keyword', '', 'string');
            $condition = array('like','%'.$keyword.'%');
            $map['id|code'] = array($condition, $condition, '_multi'=>true);
        }
        $data_list = M($mode,null)->page(!empty(I('p'))?I('p'):1, $page_row)->where($map)->order('id desc')->select();
        foreach($data_list as &$v){
        }
        $page = new Page(M($mode,null)->where($map)->count(), $page_row);
        $res['data'] = $data_list;
        $res['page'] = $page;
        return $res;
    }

    public function make_free_code($post){
        $res['status'] = false;
        $data['device_id'] = $post['device_id'];
        $www['id'] = $post['device_id'];
        $device = M('think_device',null)->where($www)->find();
        $data['device_number'] = $device['number'];
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $data['start_time'] = $post['start_time'];
        $data['end_time'] = $post['end_time'];
        $data['img'] = $post['img'];
        $data['is_used'] = 0;
        if($post['number'] > 300 || $post['number'] <= 0){
            $res['msg'] = '生成个量只能在0-300';
            return $res;
        }
        $mode_object = D2('cf_free_code');
        for($i = 0; $i < $post['number']; $i++){
            $data['code'] = $this->_make_code($post['device_id']);
            $data = $mode_object->create($data);
            if ($data) {
                $result = $mode_object->add();
                if ($result === false) {
                    $res['msg'] = '未知错误';
                    return $res;
                }
            } else {
                $res['msg'] = $mode_object->getError();
                return $res;
            }
        }
        $url = Cookie('__forward_project_level__')?:U('free_code_list',['id'=>$post['device_id']]);
        $res['url'] = $url;
        $res['status'] = true;
        $res['msg'] = '成功';
        return $res;
    }

    public function _make_code($device_id){
        $code = rand(100000,999999);
        $www['device_id'] = $device_id;
        $www['code'] = $code;
        $has = M('cf_free_code',null)->where($www)->find();
        if(!$has){
            return $code;
        }
        return $this->_make_code($device_id);
    }

    // 获得系统管理员
    public function get_access_users(){
        $map['status'] = array('egt', '0'); // 禁用和正常状态
        $data_list     = D2('AdminAccess')->where($map)->order('sort asc,id asc')->select();
        $group_object = D2('AdminGroup');
        $user_object  = D2('AdminUser');
        foreach ($data_list as $key => &$val) {
            $val['username']    = $user_object->getFieldById($val['uid'], 'username');
            $val['group_title'] = $group_object->getFieldById($val['group'], 'title');
        }
        return $data_list;
    }
    
    // 分配
    public function push_device2user($post){
        $ww1w['device_id'] = $post['device_id'];
        M('cf_user_device',null)->where($ww1w)->delete();
        M('cf_user_device',null)->add($post);
    }

    public function get_admin_device_map($map=[],$key='device_id'){
        if(S('front_access'))
            return $map;
        if($this->uid == 1){
            return $map;
        }
        $www['uid'] = $this->uid;
        $device_list = M('cf_user_device',null)->where($www)->select();
        if($device_list){
            foreach($device_list as $v){
                $list[] = $v['device_id'];
            }
            $device_ids = implode(',',$list);
            $map[$key] = array('in', $device_ids);
        }else{
            $map[$key] = array('in', '0');
        }
        return $map;
    }

    // 退款
    public function pay_back($device_id){
        // 处理未出货订单
        $www['status'] = 0;
        $www['device_id'] = $device_id;
        $shop_order = M('think_shop_order',null)->where($www)->find();
        if(!$shop_order)
        return false;
        $ddd['status'] = -4;
        M('think_shop_order',null)->where($www)->save($ddd);
        // 退款
        $ww22w['order_id'] = $shop_order['pay_order_id'];
        $order = M('cf_order',null)->where($ww22w)->find();
        if(!$order)
        return false;
        $content_str = '';
        // 半价
        if($order['is_half']){
            $ww5w['open_id'] = $order['open_id'];
            $dd5d['is_half_price'] = 1;
            $customer = M('cf_customer',null)->where($ww5w)->save($dd5d);
            $content_str .= '&半价';
        }
        // 兑换码
        if($order['free_code']){
            $ww9w['code'] = $order['free_code'];
            $dd9d['is_used'] = 0;
            $dd9d['use_time'] = '';
            M('cf_free_code',null)->where($ww9w)->save($dd9d);
            $content_str .= '&兑换码';
        }
        // 优惠券
        if($order['customer_coupon_id']){
            $ww2w['id'] = $order['customer_coupon_id'];
            $dd2d['is_used'] = 0;
            $dd2d['use_time'] = '';
            M('cf_customer_coupon',null)->where($ww2w)->save($dd2d);
            $content_str .= '&优惠券:'.$order['customer_coupon_id'];
        }
        // 酷豆
        if($order['bean_num'] && $order['bean_num'] > 0 ){
            $dd55d['open_id'] = $order['open_id'];
            $dd55d['order_id'] = $order['order_id'];
            $dd55d['status'] = 0;
            $dd55d['opt'] = '+';
            $dd55d['bean_num'] = $order['bean_num'] ;
            $dd55d['pay_price'] = 0;
            M('cf_bean_record',null)->add($dd55d);
            $this->_recount_bean_num($order['open_id']);
            $content_str .= '&酷豆:'.$order['bean_num'];
        }
        // 支付
        if($order['price'] && $order['price'] > 0 ){
            $amount = $order['price']*100;
            $getRes = API('Wechat')->pay_back($order['open_id'], $amount, '咖啡退款');
            if($getRes['result_code'] != 'SUCCESS'){
                $res['msg'] = '错误：'.$getRes['err_code_des'];
            }
            $content_str .= '&现金:'.$order['price'].'&结果:'.$res['msg'];
        }
        $dd22d['is_pay'] = -4;
        M('cf_order',null)->where($ww22w)->save($dd22d);
        // 营收处理
        $this->_make_money_record($order,'-','订单退款',$getRes);
        // 操作日志
        $title = '订单退款';
        $content = 'order_id:'.$order['order_id'].'退款项：'.$content_str;
        mLog($title,$content);
    }

    // 用户列表
    function get_user_list($where=[]){
        $res['status'] = true;
        $mode = 'nf_admin_user';
        $page_row = 10;
        $map = $where;
        if(!$where['id']){
            $keyword = I('keyword', '', 'string');
            $condition = array('like','%'.$keyword.'%');
            $map['id|username'] = array($condition, $condition, '_multi'=>true);
        }
        $data_list = M($mode,null)->page(!empty(I('p'))?I('p'):1, $page_row)->where($map)->order('id desc')->select();
        // 管理员
        $user_list = M('cf_user_info',null)->select();
        foreach($user_list as $v){
            $user_list_kv[$v['uid']] = $v;
        }
        foreach($data_list as &$v){
            $user_info = $user_list_kv[$v['id']];
            if($user_info){
                foreach($user_info as $kkk=>$vvv){
                    if(!$v[$kkk])
                    $v[$kkk] = $vvv;
                }
            }
        }
        $page = new Page(M($mode,null)->where($map)->count(), $page_row);
        $res['data'] = $data_list;
        $res['page'] = $page;
        return $res;
    }

    // 
    function get_user_money_list($where=[]){
        $res['status'] = true;
        $mode = 'cf_user_money_record';
        $page_row = 10;
        $data_list = M($mode,null)->page(!empty(I('p'))?I('p'):1, $page_row)->where($where)->order('id desc')->select();
        foreach($data_list as &$v){
            $v['order_content'] = unserialize($v['order_content']);
            $v['order_content']['order_number'] = $v['order_content']['order_id'];
            foreach($v['order_content'] as $kkk=>$vvv){
                if(!$v[$kkk]){
                    $v[$kkk] = $vvv;
                }
            }
            // 
            $v['pay_content'] = unserialize($v['pay_content']);
            $v['pay_content']['order_number'] = $v['pay_content']['partner_trade_no'];
            foreach($v['pay_content'] as $kkk=>$vvv){
                if(!$v[$kkk]){
                    $v[$kkk] = $vvv;
                }
            }
        }
        $page = new Page(M($mode,null)->where($where)->count(), $page_row);
        $res['data'] = $data_list;
        $res['page'] = $page;
        return $res;
    }

    function _recount_user_money($uid){
        $ww5w['uid'] = $uid;
        $ww5w['status'] = 1;
        $list = M('cf_user_money_record',null)->where($ww5w)->select();
        $pay_money = 0;
        foreach($list as $v){
            if($v['opt'] == '-')
                $pay_money -= $v['pay_money'];
            if($v['opt'] == '+')
                $pay_money += $v['pay_money'];
        }
        $ww6w['uid'] = $uid;
        $dd6d['pay_money'] = $pay_money;
        M('cf_user_info',null)->where($ww6w)->save($dd6d);
    }

    // 
    function user_money_record_edit($post){
        $res['status'] = false;
        $mode_object = D2('cf_user_money_record');
        $post['opt_uid'] = $this->uid;
        $post['status'] = 1;
        $post['date_time'] = date('Y-m-d H:i:s',time());
        $post['back_up'] = serialize($post);
        $data = $mode_object->create($post);
        if ($data) {
            if($data['id']){
                $res['msg'] = '禁止修改';
                $result = false;
                // $result = $mode_object->save();
            }
            else{
                $result = $mode_object->add();
            }
            $this->_recount_user_money($post['uid']);
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $_pre = '_dev';
                $url = Cookie('__forward_project_level__')?:U('user_money_record',['uid'=>$post['uid']]);
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }

    // 打款
    function user_pay($post){
        $res['status'] = false;
        if($post['code'] != '打款')
            $res['msg'] = '口令错误';
        if(!$post['remark'])
            $res['msg'] = '备注不能为空';
        if(!$post['true_name'])
            $res['msg'] = '姓名不能为空';
        if(!$post['card_bank'])
            $res['msg'] = '开户行不能为空';
        if(!$post['card_num'])
            $res['msg'] = '卡号不能为空';
        if(!$post['pay_money'])
            $res['msg'] = '金额不能为空';
        if(!$post['uid'])
            $res['msg'] = '发生错误';
        if($res['msg'])
            return $res;
        $model = new \weixin\WeixinBank([]);
        $bank_no = $post['card_num'];
        $true_name = $post['true_name'];
        $bank_code = $post['card_bank'];
        $amount = $post['pay_money']*100;
        $remark = $post['remark'];
        $getRes = API('Wechat')->pay_back_card($bank_no, $true_name, $bank_code, $amount, $remark);
        if($getRes['result_code'] != 'SUCCESS'){
            $res['msg'] = '错误：'.$getRes['err_code_des'];
            return $res;
        }
        // 营收处理
        $ddd['uid'] = $post['uid'];
        $ddd['opt'] = '-';
        $ddd['opt_type'] = '打款';
        $ddd['pay_money'] = $post['pay_money'];
        $ddd['remark'] = $post['remark'];
        $ddd['pay_content'] = \serialize($getRes);
        $ddd['payment_no'] = $getRes['payment_no'];
        $ddd['status'] = 1;
        $ddd['status_admin'] = 1;
        $ddd['date_time'] = date('Y-m-d H:i:s',time());
        $ddd['back_up'] = \serialize($ddd);
        M('cf_user_money_record',null)->add($ddd);
        $this->_recount_user_money($post['uid']);
        $res['status'] = true;
        return $res;
    }

    // 编辑
    function share_template_edit($post){
        $res['status'] = false;
        $mode_object = D2('CfDeviceWeixinTemplate');
        $data = $mode_object->create($post);
        if ($data) {
            if($data['id']){
                $result = $mode_object->save($data);
                // 更新其他
                $www['tpl_id'] = $data['id'];
                unset($data['id']);
                $tpl = M('cf_device_weixin',null)->where($www)->save($data);
            }
            else
                $result = $mode_object->add();
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $url = Cookie('__forward_project_level__')?:U('share_template');
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }

    // 用户列表
    function get_share_template_list($where=[]){
        $mode = 'cf_device_weixin_template';
        $page_row = 10;
        $map = $where;
        $data_list = M($mode,null)->page(!empty(I('p'))?I('p'):1, $page_row)->where($map)->order('id desc')->select();
        foreach($data_list as &$v){
            $v['img_url_name'] = get_cover($v['img_url']);
        }
        $page = new Page(M($mode,null)->where($map)->count(), $page_row);
        $res['data'] = $data_list;
        $res['page'] = $page;
        return $res;
    }

    // 提现
    function cash_out($post){
        $res['status'] = false;
        // 判断可用余额
        $www['uid'] = $post['uid'];
        $user_setting = M('cf_user_info',null)->where($www)->find();
        $user_setting['wx_fields'] = unserialize($user_setting['wx_fields']);
        $pay_money = $user_setting['pay_money'] - $user_setting['deposit'];
        if($pay_money < 0){
            $res['msg'] = '余额不足';
            return $res;
        }
        if($pay_money < $post['money']){
            $res['msg'] = '余额不足';
            return $res;
        }
        // 记录
        $ddd['uid'] = $post['uid'];
        $ddd['order_id'] = '';
        $ddd['order_content'] = '';
        $ddd['opt'] = '-';
        $ddd['pay_money'] = $post['money'] * (1-$user_setting['fee']*0.01);
        $ddd['opt_type'] = '提现';
        $ddd['remark'] = '提现'.$post['money'].'，手续费比例'.$user_setting['fee'].'，实际到账'.$ddd['pay_money'].'('.$user_setting['wx_fields']['nickname'].'/'.$user_setting['open_id'].')';
        $ddd['status'] = 1;
        $ddd['status_admin'] = 0;
        $ddd['pay_content'] = '';
        $ddd['payment_no'] = '';
        $ddd['open_id'] = $user_setting['open_id'];
        $ddd['date_time'] = date('Y-m-d H:i:s',time());
        $ddd['back_up'] = \serialize($ddd);
        M('cf_user_money_record',null)->add($ddd);
        $this->_recount_user_money($post['uid']);
        $res['status'] = true;
        $res['msg'] = '成功';
        return $res;
    }


}


// 数据处理
function _fix_data($data_list){
    $i=0;
    foreach($data_list as $v){
        $content = unserialize($v['content']);
        unset($content['id']);
        foreach($content as $k2k => $v2v){
            if($v2v){
                $data_list[$i][$k2k] = $v2v;
            }
        }
        $i++;
    }
    return $data_list;
}
