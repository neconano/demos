<?php
namespace app\common\model;

/**
 */
class CfDeviceTune extends Model3 {
    /**
     * 数据库表名
     * 
     */
    protected $trueTableName = 'cf_device_tune';

    /**
     * 自动验证规则
     * 
     */
    protected $_validate = array(
        array('title', 'require', '名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('price', 'require', '价格不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('goods_type', 'require', '通道号不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('water_per_cup', 'require', '每杯用水不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('material_per_cup', 'require', '每杯用料不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('material_cup_count', 'require', '料可用总杯数不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('remain_material_cup_count', 'require', '料剩余杯数不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );




}
