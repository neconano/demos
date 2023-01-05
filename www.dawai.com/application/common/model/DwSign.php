<?php
namespace app\common\model;

/**
 * 报名
 * 
 */
class DwSign extends Model3 {
    /**
     * 数据库表名
     * 
     */
    protected $trueTableName = 'dw_sign';



    public function add_sign($data){

        $data['name'] = htmlspecialchars($data['name']);
        $data['tel'] = htmlspecialchars($data['tel']);
        $data['weixin'] = htmlspecialchars($data['weixin']);
        $data['qq'] = htmlspecialchars($data['qq']);
        $data['create_time'] = time();
        
        // 获得课程信息
        $w['id'] = $data['lesson_id'];
        $lesson = D2('DwCourseLesson')->where($w)->find();
        $data['lesson_title'] = $lesson['title'];
        $data['category_id'] = $lesson['category'];
        $category_list = explode(',', $lesson['category'] ); 
        $data['category_title'] = API('Course')->search_category_index[$category_list[0]].','.API('Course')->search_category[$category_list[0]][$category_list[1]];
        $this->add($data);
    }


}
