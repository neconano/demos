<?php
namespace app\common\model;

/**
 */
class ThinkDevice extends Model3 {
    /**
     * 数据库表名
     * 
     */
    protected $trueTableName = 'think_device';

    /**
     * 自动验证规则
     * 
     */
    protected $_validate = array(
        array('number', 'require', '设备编号不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('shop_id', 'require', '场所不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('sim_phone', 'require', 'sim卡电话号不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('tune1_water_cup_count', 'require', '水可用总杯数不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('tune1_remain_water_cup_count', 'require', '水剩余杯数不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('cup_count', 'require', '杯可用总数不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('remain_cup_count', 'require', '杯剩余数不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

}
