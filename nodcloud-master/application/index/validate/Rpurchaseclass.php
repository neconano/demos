<?php
namespace app\index\validate;
use think\Validate;
class Rpurchaseclass extends Validate{
    //默认创建规则
    protected $rule = [
        ['supplier', 'require|integer', '供应商不可为空!|供应商数据不正确!'],
        ['time', 'require|date', '单据时间不可为空|单据时间不正确!'],
        ['number', 'require|RepeatNumber:create', '单据编号不可为空!|字段数据重复'],
        ['total', 'require|number', '单据金额不可为空!|单据金额数据不正确!'],
        ['actual', 'require|number', '实际金额不可为空!|实际金额数据不正确!'],
        ['money', 'require|number', '实付金额不可为空!|实付金额数据不正确!'],
        ['user', 'require|integer', '制单人不可为空!|制单人数据不正确!'],
        ['account', 'require|integer', '结算账户不可为空!|结算账户数据不正确!'],
        ['more', 'array', '扩展信息格式不正确!']
    ];
    //单据编号重复性判断
    protected function RepeatNumber($val,$rule,$data){
        $sql['number']=$val;
        $sql['id']=['neq',$data['id']];
        $nod=db('rpurchaseclass')->where($sql)->find();
        return empty($nod)?true:'单据编号[ '.$val.' ]已存在!';
    }
}