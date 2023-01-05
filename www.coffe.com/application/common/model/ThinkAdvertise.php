<?php
namespace app\common\model;

/**
 */
class ThinkAdvertise extends Model3 {
    /**
     * 数据库表名
     * 
     */
    protected $trueTableName = 'think_advertise';

    /**
     * 自动验证规则
     * 
     */
    protected $_validate = array(
        array('show_name', 'require', '名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('type', 'require', '类型不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('advertise_class_id', 'require', '类别不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('star_time', 'require', '起始日期不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('end_time', 'require', '截止日期不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    /**
     * 自动完成规则
     * 
     */
    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT),
    );


}