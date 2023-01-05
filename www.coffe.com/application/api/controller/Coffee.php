<?php
namespace app\api\controller;
use weixin\WeixinPush;

class Coffee extends \think\Controller
{
    // 重置设备状态
    public function reset_device_status(){
        $ww2w['is_online'] = 1;
        $list = M('think_device',null)->where($ww2w)->select();
        foreach($list as $v){
            $www['id'] = $v['id'];
            if($v['is_online_buffer']){
                $ddd['is_online'] = 0;
                $ddd['is_online_buffer'] = 0;
            }else{
                $ddd['is_online_buffer'] = 1;
            }
            M('think_device',null)->where($www)->save($ddd);
        }
    }

    // 每天一次处理
    public function a_day_once(){
        // 设备租金
        $list = M('cf_user_info',null)->select();
        foreach($list as $v){
            if($v['rental']){
                $www['uid'] = $v['uid'];
                $www['opt_type'] = '设备租金';
                $res = M('cf_user_money_record',null)->where($www)->order('date_time desc')->find();
                if($res){
                    if( date('Y-m-d',strtotime($res['date_time'])) == date('Y-m-d',time()) )
                        continue;
                }
                $ddd['uid'] = $v['uid'];
                $ddd['order_id'] = '';
                $ddd['order_content'] = '';
                $ddd['opt'] = '-';
                $ddd['pay_money'] = $v['rental'];
                $ddd['opt_type'] = '设备租金';
                $ddd['remark'] = '设备租金'.$v['rental'];
                $ddd['status'] = 1;
                $ddd['status_admin'] = 0;
                $ddd['pay_content'] = '';
                $ddd['payment_no'] = '';
                $ddd['open_id'] = $v['open_id'];
                $ddd['date_time'] = date('Y-m-d H:i:s',time());
                $ddd['back_up'] = \serialize($ddd);
                M('cf_user_money_record',null)->add($ddd);
                API('Coffee')->_recount_user_money($v['uid']);
            }
        }
    }
    

}


function MLog($content){
    $log['content'] = $content;
    $log['time'] = date('Y-m-d H:i:s',time());
    M('cf_log',null)->add($log);

    //写入log
    // date_default_timezone_set('PRC'); // 中国时区
    // $td= 'logs/'.date("Y-m-d").".txt";       
    // $myfile = fopen($td, "a+");
    // $the_time=date('Y-m-d H:i:s', time());
    // fwrite($myfile, $content);
    // fclose($myfile);
}
