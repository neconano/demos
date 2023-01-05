<?php
namespace app\common\model;

/**
 */
class CfUserMoneyRecord extends Model3 {
    /**
     * 数据库表名
     * 
     */
    protected $trueTableName = 'cf_user_money_record';

    /**
     * 自动验证规则
     * 
     */
    protected $_validate = array(
        array('opt', 'require', '增减不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('pay_money', 'require', '金额不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('remark', 'require', '备注不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );




}
