<?php
namespace app\common\model;

/**
 */
class CfCoupon extends Model3 {
    /**
     * 数据库表名
     * 
     */
    protected $trueTableName = 'cf_coupon';

    /**
     * 自动验证规则
     * 
     */
    protected $_validate = array(
        array('title', 'require', '名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('rebate', 'require', '折扣不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('start_time', 'require', '开始不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('end_time', 'require', '结束不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('device_ids', 'require', '设备不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );




}
