<?php
namespace app\common\model;

/**
 */
class CfCustomer extends Model3 {
    /**
     * 数据库表名
     * 
     */
    protected $trueTableName = 'cf_customer';

    /**
     * 自动验证规则
     * 
     */
    protected $_validate = array(
        // array('device_id', 'require', 'device_id不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('open_id', 'require', 'open_id不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );




}
