<?php
namespace app\index\model;
use	think\Model;
class Cashierclass extends Model{
    //销货单
    protected $type = [
        'time'=>'timestamp:Y-m-d',
        'auditingtime'=>'timestamp:Y-m-d H:i:s',
        'payinfo'    =>  'json',
        'more'    =>  'json'
    ];
    
    protected $insert = ['type' => 0, 'auditinguser' => 0, 'auditingtime' => 0, 'payinfo']; 
    
    //商户属性关联
    public function merchantinfo(){
        return $this->hasOne('Merchant','id','merchant');
    }
    
    //客户属性关联
    public function customerinfo(){
        return $this->hasOne('Customer','id','customer');
    }
    
    //制单人属性关联
    public function userinfo(){
        return $this->hasOne('User','id','user');
    }
    
    //结算账户属性关联
    public function accountinfo(){
        return $this->hasOne('Account','id','account');
    }
    
    //审核人属性关联
    public function auditinguserinfo(){
        return $this->hasOne('User','id','auditinguser');
    }
    
    //单据日期_设置器
	protected function setPayinfoAttr ($val, $data){
        if(isset($data['payinfo'])){
            return json_encode($data['payinfo'], JSON_UNESCAPED_UNICODE);
        }
		return json_encode($val, JSON_UNESCAPED_UNICODE);
	}
    
	protected function setTimeAttr ($val){
		return strtotime($val);
	}
    
    //审核状态_读取器
	protected function getTypeAttr ($val,$data){
        $arr=['0'=>'未审核','1'=>'已审核'];
        $re['name']=$arr[$val];
        $re['nod']=$val;
        return $re;
	}
	
	//付款类型_读取器
	protected function getPaytypeAttr ($val,$data){
        $arr=['0'=>'单独付款','1'=>'组合付款'];
        $re['name']=$arr[$val];
        $re['nod']=$val;
        return $re;
	}
	
    //单据金额_读取器
	protected function getTotalAttr ($val,$data){
	    return opt_decimal($val);
	}
	
	//实际金额_读取器
	protected function getActualAttr ($val,$data){
	    return opt_decimal($val);
	}
	
	//实付金额_读取器
	protected function getMoneyAttr ($val,$data){
	    return opt_decimal($val);
	}
	//赠送积分_读取器
	protected function getIntegralAttr ($val,$data){
	    return opt_decimal($val);
	}
	
}
