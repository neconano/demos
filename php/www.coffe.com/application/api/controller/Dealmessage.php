<?php
namespace app\api\controller;
use weixin\WeixinPush;

class Dealmessage extends \think\Controller
{
    public function index()
    {
        define("TOKEN", "zhuheMessage");
        if (!isset($_GET['echostr'])) {
            $this->responseMsg();
        } else {
            $this->valid();
        }
    }

    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    
    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            //用户发送的消息类型判断
            switch ($RX_TYPE)
            {
                case "text":    //文本消息
                    $result = $this->receiveText($postObj);
                    break;
                case "image":   //图片消息
                    $result = $this->receiveImage($postObj);
                    break;
                case "voice":   //语音消息
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":   //视频消息
                    // $result = $this->receiveVideo($postObj);
                    break;
                case "location"://位置消息
                    // $result = $this->receiveLocation($postObj);
                    break;
                case "link":    //链接消息
                    // $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknow msg type: ".$RX_TYPE;
                    break;
            }
            echo $result;
        }else {
            echo "";
            exit;
        }
    }

    //根据设备号获取 咖啡机上的号
    public function caffe_number($index,$shop_id)
    {
        $device = M('device','think_');
        $list=$device->where("shop_id= '$shop_id'")->select();
        for($i=0;$i<sizeof($list);$i++) {
            if($i+1==$index)
            {
                return $list[$i]['id'];
            }
        }
    }

    /*
     * 接收文本消息
     */
    private function receiveText($object)
    {
        $temp=$object->Content;
        $device_num=substr($temp , 0 , 2);
        $device_num=intval($device_num);
        $err_num=substr($temp , 2 ,1);
        $type=intval($err_num);
        $opid=$object->FromUserName;
        $user=M('user','think_');
        $list=$user->where("opid='$opid'")->find();
        $shop_id=$list['shop_id'];
        $device_id=$this->caffe_number($device_num,$shop_id);
        $device_trouble     = M('device_trouble','think_');
        $device     = M('device','think_');
        if($type=='3'){
            $data1['troubleCup']=0;
            $device_trouble->where("device_id=$device_id")->save($data1);
            $re=$device->where("id=$device_id")->find();
            if($re)
                $data2['remain_cup_count']= $re['cup_count'];  
            else
                $data2['remain_cup_count']='120';
            $device->where("id=$device_id")->save($data2);
            $value="缺杯故障清除成功,初始化120杯使用量剩余20杯会发出警报";
        } else if($type=='0'){
            $re=$device->where("id=$device_id")->find();
            if($re)
                $value="剩余水：".$re['tune1_remain_water_cup_count']."杯；剩余咖啡：".$re['tune1_remain_material_cup_count']."杯；剩余奶茶：".$re['tune2_remain_material_cup_count']."杯；剩余巧克力奶：".$re['tune3_remain_material_cup_count'];
            else
                $value="查询信息失败";
        }
        else if($type=='1'){
            $data1['troubleWater']=0;
            $device_trouble->where("device_id=$device_id")->save($data1);
            $re=$device->where("id=$device_id")->find();
            if($re)
            $data2['tune1_remain_water_cup_count']= $re['tune1_water_cup_count'];  
            else
            $data2['tune1_remain_water_cup_count']='140';
            $device->where("id=$device_id")->save($data2);
            $value="缺水故障清除成功，初始化140杯使用量剩余20杯会发出警报";
        }
        else if($type=='2'){ 
            $data1['troublePump']=0;
            $device_trouble->where("device_id=$device_id")->save($data1);
            $value="抽水泵故障清除成功";
        }else if($type=='4'){
        
            $data1['troubleTemp']=0;
            $device_trouble->where("device_id=$device_id")->save($data1);
            $value="传感器故障清除成功";
        }else if($type=='5'){
            $re=$device->where("id=$device_id")->find();
            if($re)
                $data2['tune1_remain_material_cup_count']= $re['tune1_material_cup_count'];
            else
                $data2['tune1_remain_material_cup_count']='100';
            $device->where("id=$device_id")->save($data2);
            $value="咖啡添加完毕，初始化100杯使用量剩余10杯会发出警报";
        }else if($type=='6'){
            $re=$device->where("id=$device_id")->find();
            if($re)
                $data2['tune2_remain_material_cup_count']= $re['tune2_material_cup_count'];
            else
                $data2['tune2_remain_material_cup_count']='100';
            $device->where("id=$device_id")->save($data2);
            $value="奶茶添加完毕，初始化100杯使用量剩余10杯会发出警报";
        }else if($type=='7'){
            $re=$device->where("id=$device_id")->find();
            if($re)
                $data2['tune3_remain_material_cup_count']= $re['tune3_material_cup_count'];
            else
                $data2['tune3_remain_material_cup_count']='100';
            $device->where("id=$device_id")->save($data2);
            $value="巧克力奶添加完毕，初始化100杯使用量剩余10杯会发出警报";
        }
        // 目前理解所有商场的管理员都在这个服务号中提示      
        $template_id="FJOpNL0KNxVo5WDqux-voEaLvkE4_o3OBZWzIfSrb5o";
        $appid="wxe654bdc630a2f94f";
        $appsecret="ea654fab055b2c312cc2084c2d33108f";
        $url="http://pay.itooks.com";
        $shop = M('shop','think_');
        $shop_data=$shop->where("id= '$shop_id'")->find();
        if($shop_data)
            $location=$device_num."#咖啡机：".$shop_data['location'];//下面好像没有用
        else
            return;
        $rdata=array();
        $user=M('user','think_');
        $list=$user->where("shop_id= '$shop_id'")->select();
        for($i=0;$i<sizeof($list);$i++) {
            if($list[$i]['opid'])
                $rdata[$i]=$list[$i]['opid'];
        }
        $s=new WeixinPush($appid,$appsecret);
        for($k=0;$k<sizeof($rdata);$k++) {
            $time =  date('Y-m-d H:i:s',time());
            $mydata = '{
                        "touser":"'.$rdata[$k].'",
                        "template_id":"'.$template_id.'",
                        "url":"'.$url.'",            
                        "data":{
                                "first": {
                                    "value":"管理员你好，咖啡机设备信息提示：",
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
                                    "value":"'.$time.'",
                                    "color":"#173177"
                                }
                            }
                        }';
            $s->https_request($mydata);
        }
    }

    /*
     * 接收图片消息
     */
    private function receiveImage($object)
    {
        $content = "你发送的是图片，地址为：".$object->PicUrl;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收语音消息
     */
    private function receiveVoice($object)
    {
        $content = "你发送的是语音，媒体ID为：".$object->MediaId;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收视频消息
     */
    private function receiveVideo($object)
    {
        $content = "你发送的是视频，媒体ID为：".$object->MediaId;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收位置消息
     */
    private function receiveLocation($object)
    {
        $content = "你发送的是位置，纬度为：".$object->Location_X."；经度为：".$object->Location_Y."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收链接消息
     */
    private function receiveLink($object)
    {
        $content = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 回复文本消息
     */
    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    
}
