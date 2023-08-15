<?php
namespace app\common\api;
use app\common\api\Base;
use \think\Log;
use \think\Cookie;
use neco\Wechat\EasyWeChat;
use think\Config;

class Wechat extends Base
{   
    private $openid = '';

    // 授权
    public function init(){
        // Log::write('debug','log',true);
        // 回调阶段立即返回
        $callback = Config::get('oauth.callback');
        if( false !== strpos($_SERVER['REQUEST_URI'],$callback)){
            return;
        }
        if(Cookie::get('openid')){
            $this->openid = Cookie::get('openid');
        }else{
            $call_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            Cookie::set('call_url',$call_url);
            $response = Easywechat::oauth()->scopes(['snsapi_userinfo'])->redirect()->send();
            return $response;
        }
        return $this->openid;
    }

    // 授权回调
    function oauth_callback(){
        $user_info = Easywechat::oauth()->user();
        $user_info = $user_info->toArray();
        API('Coffee')->init_user_lite($user_info);
        Cookie::set('openid',$user_info['id'],600);
        // Cookie::set('openid',null);
        header('location:'. Cookie::get('call_url')?:'/');
    }

    // 微信接口配置URL
    public function check(){
        //获得参数 signature nonce token timestamp echostr
        $nonce     = $_GET['nonce'];
        $token     = 'neconano';
        $timestamp = $_GET['timestamp'];
        $echostr   = $_GET['echostr'];
        $signature = $_GET['signature'];
        //形成数组，然后按字典序排序
        $array = array();
        $array = array($nonce, $timestamp, $token);
        sort($array);
        //拼接成字符串,sha1加密 ，然后与signature进行校验
        $str = sha1( implode( $array ) );
        if( $str == $signature && $echostr ){
            //第一次接入weixin api接口的时候
            echo  $echostr;
            exit;
        }
    }

    // 支付
    public function pay_back($openid, $amount, $desc='企业付款'){
        // $openid = 'oMmncweQIjPlbsSYVN3-3gOSsaSI';
        $merchantPayData = [
            'partner_trade_no' => 'bbb'.rand(1000,10000).'bbb'.time(), //随机字符串作为订单号，跟红包和支付一个概念。
            'openid' => $openid, //收款人的openid
            'check_name' => 'NO_CHECK',  //文档中有三种校验实名的方法 NO_CHECK OPTION_CHECK FORCE_CHECK
            're_user_name'=>'',     //OPTION_CHECK FORCE_CHECK 校验实名的时候必须提交
            'amount' => $amount,  //单位为分
            'desc' => $desc,
            'spbill_create_ip' => get_ip(),  //发起交易的IP地址
        ];
        $result = Easywechat::merchant_pay()->send($merchantPayData);
        return $result;
    }
    
    // 支付到卡
    public function pay_back_card($bank_no, $true_name, $bank_code, $amount, $desc='企业转账'){
        $model = new \weixin\WeixinBank([]);
        $partner_trade_no = 'ppp'.rand(1000,10000).'ppp'.time();
        $result = $model->paybank($bank_no, $true_name, $bank_code, $amount, $partner_trade_no, $desc);
        return $result;
    }

    // 
    public function make_rsa(){
        // 获得公钥，复制创建 public.pem
        $model = new \weixin\WeixinBank([]);
        $model->rsa();
        // 使用命令进行转码，覆盖之前生成文件
        // openssl rsa -RSAPublicKey_in -in public.pem -pubout

        // 1、 调用获取RSA公钥API获取RSA公钥，落地成本地文件，假设为public.pem
        // 2、 确定public.pem文件的存放路径，同时修改代码中文件的输入路径，加载RSA公钥
        // 3、 用标准的RSA加密库对敏感信息进行加密，选择RSA_PKCS1_OAEP_PADDING填充模式
        //       （eg：Java的填充方式要选 " RSA/ECB/OAEPWITHSHA-1ANDMGF1PADDING"）
        // 4、 得到进行rsa加密并转base64之后的密文
        // 5、 将密文传给微信侧相应字段，如付款接口（enc_bank_no/enc_true_name）
    }




}
