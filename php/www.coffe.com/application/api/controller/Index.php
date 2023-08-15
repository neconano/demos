<?php
namespace app\api\controller;
use weixin\WeixinPush;

class Index extends \think\Controller
{
    // 重置设备重启状态
    public function reset_restart($deviceId=''){
        $results['status'] = 0;
        $www['number'] = $deviceId;
        $device = M('think_device',null)->where($www)->find();
        if($device){
            $results['status'] = 1;
            $ddd['is_reboot'] = 0;
            M('think_device',null)->where($www)->save($ddd);
        }
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
        exit;
    }

    //查询定单号(咖啡机监听查询本机是否有订单，如果有订单，根据返回通道出咖啡)（附带错误上报功能）
    //http://pay.zhuhemedia.com/Api/Index/deviceStatic_orders/deviceId/2035204777/troubleInfo/33/troubleType/-1
    public function deviceStatic_orders($deviceId=''){
        if(!$deviceId)
        return;
        // 设备在线
        $ddd['is_online'] = 1;
        $www['number'] = $deviceId;
        M('think_device',null)->where($www)->save($ddd);
        // 设备重启
        $device = M('think_device',null)->where($www)->find();
        if($device['is_reboot']){
            $results['restart'] = $device['is_reboot']?:0;
            echo json_encode($results, JSON_UNESCAPED_UNICODE);
            exit;
        }
        $the_time=date('Y-m-d H:i:s', time());
        $deviceId1      = $_REQUEST['deviceId'];
        $troubleInfo    = $_REQUEST['troubleInfo'];
        $troubleType    = $_REQUEST['troubleType'];
        $device         = M('device');
        $list           = $device->where("number= '$deviceId1'")->find();
        $deviceId       = $list['id'];
        $shop_id        = $list['shop_id'];
        $caffe_number   = $this->caffe_number($deviceId1,$shop_id);
        // 查询该机器是否有有效订单
        $order_info     = M('')->query("SELECT id,goods_type FROM think_shop_order WHERE device_id='$deviceId' AND status='0' order by created_at  limit 1  ");
        $goods_type     = $order_info[0]['goods_type'];
        $order_id       = $order_info[0]['id'];
        $device_trouble = M('device_trouble');
        //先检查是否有这个设备
        if ($_REQUEST['troubleType'] == '03') {
            $this->weixin_reflect('03',$shop_id,$caffe_number);
            $data1['troubleCup'] = 1;
            $device_trouble->where("device_id=$deviceId")->save($data1);
        }else if  ($_REQUEST['troubleType'] == '01') {
            $this->weixin_reflect('01',$shop_id,$caffe_number);
            $data1['troubleWater'] = 1;
            $device_trouble->where("device_id=$deviceId")->save($data1);
        }else if  ($_REQUEST['troubleType'] == '04') {
            $this->weixin_reflect('04',$shop_id,$caffe_number);
            $data1['troublePump'] = 1;
            $device_trouble->where("device_id=$deviceId")->save($data1);
        }else if  ($_REQUEST['troubleType'] == '02') {
            $this->weixin_reflect('02',$shop_id,$caffe_number);
            $data1['troubleTemp'] = 1;
            $device_trouble->where("device_id=$deviceId")->save($data1);
        }else if  ($_REQUEST['troubleType'] == '08') {
            $data1['troubleHot'] = 1;
            $device_trouble->where("device_id=$deviceId")->save($data1);
        }else if  ($_REQUEST['troubleType'] == '40') {

        }else if  ($_REQUEST['troubleType'] == '-2') {
            //-2   咖啡机无应答,修改数据库 1，微信返，写log
            $device_trouble         = M('device_trouble');
            $data1['troubleUnknow'] = '1';
            $device_trouble->where("device_id=$deviceId")->save($data1); 
            //写入log
            $content = $the_time."&".$deviceId1."&".$troubleType."&".$troubleInfo."\r\n";
            MLog($content);
            //给微信反馈
            $this->weixin_reflect('08',$shop_id,$caffe_number);
        }else{
            if ($_REQUEST['troubleType'] == '-1') {
                //-1   咖啡机有应答，但检测不出什么指令
                $content = $the_time."*".$deviceId1."*".$troubleType."*".$troubleInfo."\r\n";
                //写入log
                MLog($content);
            }
        }       
        // 返回状态,根据订单支付的咖啡返回类型出货
        $results = array(
            'flag'      => '',
            'orderId'   => '',
            'type'      => ''
        );
        
        $results['flag']    = $order_info==null?0:1;
        $results['type']    = $goods_type==null?'':$goods_type;
        // if($deviceId == '76'){
        //     $results['type']    = 5;
        // }
        $results['orderId'] = $order_info[0]['id']==null?'':$order_info[0]['id'];
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    // 出货后状态重置（附带错误上报功能）
    // http://pay.zhuhemedia.com/Api/Index/update_orders_trouble?deviceId=2035204777&orderType=1&troubleType=&troubleInfo=&orderId=6053&code="dsfdsfdsf"
    // http://pay.zhuhemedia.com/Api/Index/update_orders_trouble?deviceId=2050325030&orderId=49137&orderType=1&troubleType=-1&troubleInfo=-1&code=-1
    public function update_orders_trouble(){
        $the_time=date('Y-m-d H:i:s', time());
        @$deviceId      = $_REQUEST['deviceId'];
        @$orderId       = $_REQUEST['orderId'];
        @$orderType     = $_REQUEST['orderType'];//0 第一通道，1 第二通道， 2 第三通道
        @$troubleType   = $_REQUEST['troubleType'];
        @$troubleInfo   = $_REQUEST['troubleInfo'];
        @$code          = $_REQUEST['code'];
        //写入log
        $content = $the_time."#".$deviceId."#".$orderId."#".$orderType."#".$troubleType."#".$troubleInfo."#".$code."\r\n";
        if($_REQUEST['troubleType'] == '-1') {
            //-1   咖啡机有应答，但检测不出什么指令 只写log
            $content = $the_time."%".$deviceId."%".$orderId."%".$orderType."%".$troubleType."%".$troubleInfo."%".$code."\r\n";
        }
        MLog($content);
        $device             = M('device');
        $info               = $device->where("number='$deviceId'")->find();
        $shop_id            = $info['shop_id'];
        $caffe_number       = $this->caffe_number($deviceId,$shop_id);
        $deviceId           = $info['id'];
        @$shop_order        = M('shop_order');
        @$device_trouble    = M('device_trouble');
        $tr_type            = $_REQUEST['troubleType'];
        // 有问题，去提醒，并将咖啡机变成不可用
        if( $tr_type!='40' && $tr_type!='-1' )  {  
            //先检查是否有这个设备
            if ($_REQUEST['troubleType'] == '03') {
                $this->weixin_reflect('03',$shop_id,$caffe_number);
                $data1['troubleCup'] = 1;
                $device_trouble->where("device_id=$deviceId")->save($data1);
            }else if  ($_REQUEST['troubleType'] == '01') {
                $this->weixin_reflect('01',$shop_id,$caffe_number);
                $data1['troubleWater'] = 1;
                $device_trouble->where("device_id=$deviceId")->save($data1);
            }else if  ($_REQUEST['troubleType'] == '04') {
                $this->weixin_reflect('04',$shop_id,$caffe_number);
                $data1['troublePump'] = 1;
                $device_trouble->where("device_id=$deviceId")->save($data1);
            }else if  ($_REQUEST['troubleType'] == '02') {
                $this->weixin_reflect('02',$shop_id,$caffe_number);
                $data1['troubleTemp'] = 1;
                $device_trouble->where("device_id=$deviceId")->save($data1);
            }else if  ($_REQUEST['troubleType'] == '08') {
                $data1['troubleHot'] = 1;
                $device_trouble->where("device_id=$deviceId")->save($data1);
            }
            $data['status']	=-1;
            $shop_order->where("id=$orderId")->save($data);
        }else{  
            // 将咖啡机变成可用
            $data['status']	=1;
            $shop_order->where("id=$orderId")->save($data);
            // 更新设备信息
            $device->where("id=$deviceId")->setDec('tune1_remain_water_cup_count');//水余杯
            $device->where("id=$deviceId")->setDec('remain_cup_count');//杯余数
            // 处理订单，不足报警
            if($orderType==1) {
                $device->where("id=$deviceId")->setDec('tune1_remain_material_cup_count');
                $tune1_remain_material_cup_count=intval($info['tune1_remain_material_cup_count'])-1;
                if($tune1_remain_material_cup_count<10)
                    $this->weixin_reflect('05',$shop_id,$caffe_number);
            }else if($orderType==2) {
                $device->where("id=$deviceId")->setDec('tune2_remain_material_cup_count');
                $tune2_remain_material_cup_count=intval($info['tune2_remain_material_cup_count'])-1;
                if($tune2_remain_material_cup_count<10)
                    $this->weixin_reflect('06',$shop_id,$caffe_number);
            }else if($orderType==3) {
                $device->where("id=$deviceId")->setDec('tune3_remain_material_cup_count');
                $tune3_remain_material_cup_count=intval($info['tune3_remain_material_cup_count'])-1;
                if($tune3_remain_material_cup_count<10)
                    $this->weixin_reflect('07',$shop_id,$caffe_number);
            }
            $tune1_remain_water_cup_count=intval($info['tune1_remain_water_cup_count'])-1;
            if($tune1_remain_water_cup_count<20)
                $this->weixin_reflect('09',$shop_id,$caffe_number);
            $remain_cup_count=intval($info['remain_cup_count'])-1;
            if($remain_cup_count<20)
                $this->weixin_reflect('03',$shop_id,$caffe_number);
        }
    }

    //字符串转十六进制
    function strToHex($temp){
        $tune1_mater    = "";
        $tune1_mater    = dechex(intval($temp));
        if(strlen($tune1_mater)==2)
            $tune1_mater='00'.$tune1_mater;
        else if(strlen($tune1_mater)==3)
            $tune1_mater='0'.$tune1_mater;
        else
            $tune1_mater='0019';
        return $tune1_mater;
    }
    
    //remote http://pay.itooks.com/Api/Index/sim_money_traffic/number/2030401576/remain_sim_traffic/4/remain_sim_money
    public function sim_money_traffic(){
        $results = array(
            'results' => ''
        );
        $device = M('device');
        $number = $_REQUEST['number'];
        if(isset($_REQUEST['remain_sim_traffic']))
            $data['remain_sim_traffic'] = $_REQUEST['remain_sim_traffic'];
        if(isset($_REQUEST['remain_sim_money']))
            $data['remain_sim_money'] = $_REQUEST['remain_sim_money'];
        if($device->where("number='$number'")->save($data)){
            $results['results'] = '1';
        }else{
            $results['results'] = '0';
        }
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }
    
    //给微信反馈
    public function weixin_reflect($type,$shop_id='',$caffe_number){
        // 设备在线
        if($type=='-7' && $caffe_number){
            $ddd['is_online'] = 1;
            $www['number'] = $caffe_number;
            M('think_device',null)->where($www)->save($ddd);
            exit;
        }
        // 目前理解所有商场的管理员都在这个服务号中提示      
        $template_id    = "FJOpNL0KNxVo5WDqux-voEaLvkE4_o3OBZWzIfSrb5o";
        $appid          = "wxe654bdc630a2f94f";
        $appsecret      = "ea654fab055b2c312cc2084c2d33108f";
        $url            = "http://pay..com";
        $shop           = M('shop');
        $shop_data      = $shop->where("id= '$shop_id'")->find();
        if($shop_data)
            $location=$caffe_number."#设备：".$shop_data['location'];  
        else
            return;
        $data=array();
        $j=0;
        $user=M('user');
        $list=$user->where("shop_id= '$shop_id'")->select();
        for($i=0;$i<sizeof($list);$i++) {
            if($list[$i]['opid']){
                $data[$i]=$list[$i]['opid'];
                $j++;
            }
        }
        $user=M('administrator');
        $list=$user->select();
        for($i=0;$i<sizeof($list);$i++) {
            if($list[$i]['opid'])
                $data[$j++]=$list[$i]['opid'];
        }
        $wx_push=new \Api\Common\WeixinPush($appid,$appsecret);
        for($k=0;$k<sizeof($data);$k++) {
            if($type=='03'){
                $value="缺杯报警";
            }else if($type=='01'){
                $value="《机器没有水请更换，重新启动机器》";
            }else if($type=='02'){
                $value="抽水泵故障";
            }else if($type=='04'){
                $value="传感器故障";
            }else if($type=='05'){
                $value="缺咖啡";
            }else if($type=='06'){
                $value="缺巧克力奶";
            }else if($type=='07'){
                $value="缺奶茶";
            }else if($type=='09'){
                $value="缺水警报";
            }else if($type=='08'){
                $value="!!!机器故障，请重新启动机器!!!";
            }else {
                $value="未知故障";
            }
            $mydata = '{
                            "touser":"'.$data[$k].'",
                            "template_id":"'.$template_id.'",
                            "url":"'.$url.'",            
                            "data":{
                                    "first": {
                                        "value":"管理员你好，设备出现报警",
                                        "color":"#173177"
                                    },
                                    "alarmIP": {
                                        "value":"'.$location.'",
                                        "color":"#173177"
                                    },
                                    "alarmType":{
                                        "value":"'.$value.'",
                                        "color":"#173177"
                                    },
                                    "alarmTime": {
                                        "value":"'.date('Y-m-d H:i:s',time()).'",
                                        "color":"#173177"
                                    }
                                    
                            }
                        }';
            $wx_push->https_request($mydata);
        }
    }

    //根据设备号获取 咖啡机上的号
    public function caffe_number($deviceId,$shop_id){
        $device = M('device');
        $list=$device->where("shop_id= '$shop_id'")->select();
        for($i=0;$i<sizeof($list);$i++) {
            if($list[$i]['number']==$deviceId)
               return $i+1;
        }
    }

    //http://pay.itooks.com/Api/Index/Api/Index/removeDeviceTemp/deviceId/2030401576
    public function removeDeviceTemp(){
        $device = M('device');
        $deviceId = $_REQUEST['deviceId'];
        $list=$device->where("number='$deviceId'")->find();
        $deviceId=$list['id'];
        $device_trouble     = M('device_trouble');
        $data['troubleHot'] = 0;
        $device_trouble->where("device_id=$deviceId")->save($data);
    }

    //test:http://192.168.1.100/caffe/Api/Index/get_ad/deviceId/2024964369
    //remote http://pay.zhuhemedia.com/Api/Index/get_ad/deviceId/2029116555
    public function get_ad(){
        $results = array(
            'setting' => '',
            'Resource' => []
        );
        $deviceId = $_REQUEST['deviceId'];
        $device = M('device');
        $list=$device->where("number='$deviceId'")->find();
        $deviceId=$list['id'];
        $sql = M();
        $ad_resourse = $sql->query(
            "SELECT think_advertise.star_time,think_advertise.end_time,think_advertise.file_name,think_advertise.show_name,think_advertise.background
            FROM think_advertise_device left join think_advertise 
            on think_advertise_device.advertise_id=think_advertise.id
            where think_advertise_device.device_id = '$deviceId' ");
        $device_settings_info = $sql->query(
            "SELECT think_device.`tune1_water_per_cup`,think_device.`tune1_material_per_cup`,
            think_device.`tune2_water_per_cup`,think_device.`tune2_material_per_cup`,
            think_device.`tune3_water_per_cup`,think_device.`tune3_material_per_cup`,
            think_device.`tune1_water_cup_count`,think_device.`tune1_material_cup_count`,
            think_device.`tune2_material_cup_count`,
            think_device.`tune3_material_cup_count`,
            think_device.`tune1_remain_water_cup_count`,think_device.`tune1_remain_material_cup_count`,
            `tune2_remain_material_cup_count`,
            think_device.`tune3_remain_material_cup_count`
            FROM think_advertise_device 
            left join think_device 
            on think_advertise_device.device_id=think_device.id
            where think_advertise_device.device_id = '$deviceId' limit 1");
        $tune1_mater    = $device_settings_info['tune1_material_per_cup'];
        $tune1_mater    = $this->strToHex($tune1_mater);
        $tune2_mater    = $device_settings_info['tune2_material_per_cup'];
        $tune2_mater    = $this->strToHex($tune2_mater);
        $tune3_mater    = $device_settings_info['tune3_material_per_cup'];
        $tune3_mater    = $this->strToHex($tune3_mater);
        $tune1_water    = $device_settings_info['tune1_water_per_cup'];
        $tune1_water    = $this->strToHex($tune1_water);
        $tune2_water    = $device_settings_info['tune2_water_per_cup'];
        $tune2_water    = $this->strToHex($tune2_water);
        $tune3_water    = $device_settings_info['tune2_water_per_cup'];
        $tune3_water    = $this->strToHex($tune3_water);
        $director       = $tune1_mater.$tune2_mater.$tune3_mater.$tune1_water.$tune2_water.$tune3_water."000100010001000000500050000000004010000000000000";
        $results['setting']=$director;
        date_default_timezone_set('PRC'); // 中国时区
        $td = date("Y-m-d",strtotime("+1 day"))." 00:00:00";
        $res_arr = array();
        for($i=0;$i<sizeof($ad_resourse);$i++){
           if($td>=$ad_resourse[$i]['star_time']&&$td<=$ad_resourse[$i]['end_time']){
                $arr['name'] = $ad_resourse[$i]['show_name'];
                $img = getImg($ad_resourse[$i]['file_name']);
                $arr['url'] = $img;
                if(!$img)
                $arr['url'] = DO_MAIN.'/Public/Files/Advertise/'.$ad_resourse[$i]['file_name'];
                // $arr[$i]['url'] ='http://192.168.1.103/caffe'.'/Public/Files/Advertise/'.$ad_resourse[$i]['file_name'];
                if($ad_resourse[$i]['background']==null){
                    $arr['backgroundName'] = "";
                    $arr['backgroundUrl'] = "";
                }else{
                    $arr['backgroundName'] = $ad_resourse[$i]['background'];
                    $arr['backgroundUrl'] = DO_MAIN.'/Public/Files/Advertise/'.$ad_resourse[$i]['background'];
                    // $arr[$i]['backgroundUrl'] = 'http://192.168.1.103/cae'.'/Public/Files/Advertise/'.$ad_resourse[$i]['background'];
                }
                $res_arr[]=$arr;
           }
        }
        $results['Resource'] = $res_arr;
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    //test:http://192.168.1.100/caffe/Api/Index/get_ad/deviceId/2024964369
    //remote //http://pay.zhuhemedia.com/Api/Index/get_ad/deviceId/2035204777
    public function get_ad2(){
        $results = array(
            'setting'  => '',
            'Resource' => []
        );
        $deviceId       = $_REQUEST['deviceId'];
        $device         = M('device');
        $list           = $device->where("number='$deviceId'")->find();
        $deviceId       = $list['id'];
        $device_trouble = M('device_trouble');
        $datab['troubleUnknow'] = 0;
        $datab['troubleWater']  = 0;
        $datab['troublePump']   = 0;
        $datab['troubleTemp']   = 0;
        $datab['troubleHot']    = 0;
        $datab['troubleCup']    = 0;
        $device_trouble->where("device_id=$deviceId")->save($datab);
        $sql = M();
        $ad_resourse = $sql->query(
            "SELECT think_advertise.star_time,think_advertise.end_time,think_advertise.file_name,think_advertise.show_name,think_advertise.background
            FROM think_advertise_device left join think_advertise 
            on think_advertise_device.advertise_id=think_advertise.id
            where think_advertise_device.device_id = '$deviceId' ");
        $device_settings_info = $sql->query(
            "SELECT think_device.`tune1_water_per_cup`,think_device.`tune1_material_per_cup`,
            think_device.`tune2_water_per_cup`,think_device.`tune2_material_per_cup`,
            think_device.`tune3_water_per_cup`,think_device.`tune3_material_per_cup`,
            think_device.`tune1_water_cup_count`,think_device.`tune1_material_cup_count`,
            think_device.`tune2_material_cup_count`,
            think_device.`tune3_material_cup_count`,
            think_device.`tune1_remain_water_cup_count`,think_device.`tune1_remain_material_cup_count`,
            `tune2_remain_material_cup_count`,
            think_device.`tune3_remain_material_cup_count`
            FROM think_advertise_device 
            left join think_device 
            on think_advertise_device.device_id=think_device.id
            where think_advertise_device.device_id = '$deviceId' limit 1");
        $tune1_mater    = $device_settings_info['tune1_material_per_cup'];
        $tune1_mater    = $this->strToHex($tune1_mater);
        $tune2_mater    = $device_settings_info['tune2_material_per_cup'];
        $tune2_mater    = $this->strToHex($tune2_mater);
        $tune3_mater    = $device_settings_info['tune3_material_per_cup'];
        $tune3_mater    = $this->strToHex($tune3_mater);
        $tune1_water    = $device_settings_info['tune1_water_per_cup'];
        $tune1_water    = $this->strToHex($tune1_water);
        $tune2_water    = $device_settings_info['tune2_water_per_cup'];
        $tune2_water    = $this->strToHex($tune2_water);
        $tune3_water    = $device_settings_info['tune2_water_per_cup'];
        $tune3_water    = $this->strToHex($tune3_water);
        $director       = $tune1_mater.$tune2_mater.$tune3_mater.$tune1_water.$tune2_water.$tune3_water."000100010001000000500050000000004010000000000000";
        $results['setting']=$director;
        date_default_timezone_set('PRC'); // 中国时区
        $td=date("Y-m-d")." 00:00:00";
        $res_arr = array();
        for($i=0;$i<sizeof($ad_resourse);$i++){
            if($td>=$ad_resourse[$i]['star_time']&&$td<=$ad_resourse[$i]['end_time']){
                $arr['name'] = $ad_resourse[$i]['show_name'];
                $img = getImg($ad_resourse[$i]['file_name']);
                $arr['url'] = $img;
                if(!$img)
                $arr['url'] = DO_MAIN.'/Public/Files/Advertise/'.$ad_resourse[$i]['file_name'];
                // $arr[$i]['url'] ='http://192.168.1.103/caffe'.'/Public/Files/Advertise/'.$ad_resourse[$i]['file_name'];
                if($ad_resourse[$i]['background']==null){
                    $arr['backgroundName'] = "";
                    $arr['backgroundUrl'] = "";
                }else{
                    $arr['backgroundName'] = $ad_resourse[$i]['background'];
                    $arr['backgroundUrl'] = DO_MAIN.'/Public/Files/Advertise/'.$ad_resourse[$i]['background'];
                    // $arr[$i]['backgroundUrl'] = 'http://192.168.1.103/caffe'.'/Public/Files/Advertise/'.$ad_resourse[$i]['background'];
                }
                $res_arr[]=$arr;
            }
        }
        $results['Resource'] = $res_arr;
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
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

function getImg($id){
    $www['id'] = $id;
    $file = M('nf_admin_upload',null)->where($www)->find();
    if($img){
        $img = $file['path'];
        return 'http://coffee.zhuhemedia.com/uploads'.$img;
    }
    return null;
}

