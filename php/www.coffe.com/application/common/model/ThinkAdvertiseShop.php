<?php
namespace app\common\model;

/**
 */
class ThinkAdvertiseShop extends Model3 {
    /**
     * 数据库表名
     * 
     */
    protected $trueTableName = 'think_advertise_weixin';

    /**
     * 自动验证规则
     * 
     */
    protected $_validate = array(
        array('advertise_id', 'require', '广告不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );



}