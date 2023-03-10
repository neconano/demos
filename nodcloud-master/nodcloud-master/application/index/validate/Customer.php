<?php
namespace app\index\validate;
use think\Validate;
class Customer extends Validate{
    //默认创建规则
    protected $rule = [
        ['name', 'require|RepeatName:create', '客户名称不可为空!|字段数据重复'],
        ['number', 'RepeatNumber:create', '字段数据重复'],
        ['tel', 'CheckTel', '字段格式错误'],
        ['birthday', 'date', '客户生日格式错误!'],
        ['account', 'number', '银行账号格式错误!'],
        ['tax', 'alphaNum|length:15,20', '客户税号格式错误!|客户税号长度错误!'],
        ['email', 'email', '邮箱地址格式错误!'],
        ['more', 'array', '扩展信息格式不正确!']
    ];
    //场景规则
    protected $scene = [
        'update'  =>  [
            'name'=>'require|RepeatName:update',
            'number'=>'RepeatNumber:update',
            'tel',
            'birthday',
            'account',
            'tax',
            'email',
            'more'
        ]
    ];
    //客户名称重复性判断
    protected function RepeatName($val,$rule,$data){
        $sql['name']=$val;
        $rule=='update'&&($sql['id']=['neq',$data['id']]);
        $nod=db('customer')->where($sql)->find();
        return empty($nod)?true:'客户名称[ '.$val.' ]已存在!';
    }
    //客户编号重复性判断
    protected function RepeatNumber($val,$rule,$data){
        $sql['number']=$val;
        $rule=='update'&&($sql['id']=['neq',$data['id']]);
        $nod=db('customer')->where($sql)->find();
        return empty($nod)?true:'客户编号[ '.$val.' ]已存在!';
    }
    //联系电话格式判断
    protected function CheckTel($val,$rule,$data){
        preg_match(get_regex('tel'), $val, $tel, PREG_OFFSET_CAPTURE, 0);//手机号正则判断
        preg_match(get_regex('phone'), $val, $phone, PREG_OFFSET_CAPTURE, 0);//座机正则判断
        if(empty($tel) && empty($phone)){
            return '联系电话[ '.$val.' ]格式不正确!';
        }else{
            return true;
        }
    }
}