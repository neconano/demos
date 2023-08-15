<?php
namespace app\common\model;

/**
 */
class CfOrder extends Model3 {
    /**
     * 数据库表名
     * 
     */
    protected $trueTableName = 'cf_order';

    /**
     * 自动验证规则
     * 
     */
    protected $_validate = array(
        array('open_id', 'require', 'open_id不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('order_id', 'require', 'order_id不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('tune_id', 'require', 'tune_id不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

}
