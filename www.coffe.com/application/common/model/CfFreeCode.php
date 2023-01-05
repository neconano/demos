<?php
namespace app\common\model;

/**
 */
class CfFreeCode extends Model3 {
    /**
     * 数据库表名
     * 
     */
    protected $trueTableName = 'cf_free_code';

    /**
     * 自动验证规则
     * 
     */
    protected $_validate = array(
        array('device_id', 'require', 'device_id不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('code', 'require', 'code不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('device_number', 'require', '设备编号不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('start_time', 'require', '开始时间不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('end_time', 'require', '截至时间不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('img', 'require', '图片不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );




}
