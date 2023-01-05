<?php
namespace app\common\model;

/**
 * 课程安排
 * 
 */
class DwCourseLessonSchedule extends Model3 {
    /**
     * 数据库表名
     * 
     */
    protected $trueTableName = 'dw_course_lesson_schedule';


    /**
     * 自动验证规则
     *
     */
    protected $_validate = array(
        array('title2','require','标题必须填写', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('title2', '1,1024', '标题长度为1-32个字符', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH),
        array('teacher','require','老师必须填写', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('study_time','require','建议时长必须填写', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('study_time1','require','建议时长必须填写', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
    );


}
