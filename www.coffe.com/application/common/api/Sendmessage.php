<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2017/8/23
 * Time: 9:28
 */

namespace app\common\api;


use think\Db;

class Sendmessage extends Base
{



    private  $appId='82ace191ebca4b008ee238b556cb8c61';
    private $templateId='127002';
    private $accountsid='74b827f850d3327db2ec240025a0e9f1';
    private  $token='bd40f9c5b2a7800bffbeab0154baa7a8';


    /**
     *  发送手机验证码
     * @param $phone            手机号
     * @param string $appId
     * @param string $templateId
     */
    public function send_code($phone,$appId='',$templateId='')
    {
        $code=Db::table('nc_tel_code')->where('phone','=',$phone)->order('id desc')->find();
        if ($code['time']+60>time()){
            return ['code'=>false,'msg'=>'请勿重复发送验证码'];
        }
        $code_num=Db::table('nc_tel_code')->where('phone','=',$phone)->whereTime('create_time','today')->count();
        if ($code_num>5){
            return ['code'=>false,'msg'=>'验证码数量超出限制'];
        }
        //初始化
        $options['accountsid']=$this->accountsid;
        $options['token']=$this->token;
        $ucpass = new Ucpaas($options);
        //短信验证码
        $appId = empty($appId)?$this->appId:$appId;
        $to = $phone;
        $templateId = empty($templateId)?$this->templateId:$templateId;
        $param=rand(1000,9999);
        $arr=$ucpass->templateSMS($appId,$to,$templateId,$param);
        if (substr($arr,21,6) == 000000) {
            $data=[
                'phone'=>$phone,
                'code'=>$param,
                'create_time'=>time(),
                'ip'=>$this->request->ip(),
            ];
            Db::table('nc_tel_code')->insert($data);
            return ['code'=>true,'msg'=>'短信验证码已发送成功，请注意查收短信'];
        }else{
            return ['code'=>false,'msg'=>'短信验证码发送失败，请联系客服'];
        }
    }




}