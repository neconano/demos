<?php
namespace app\common\api;
use app\common\api\Base;
use think\Db;

/**
 * 课程
 */
class Course extends Base
{   


    // 授课方式
    public $lesson_type_index = [
        '1' => '在线录播',
        '2' => '在线直播',
        '3' => '线下授课',
    ];

    // 搜索分类
    public $search_category_index = [
        '1' => '留学英语',
        '2' => '日语课程',
        '3' => '求职课程',
        '4' => '大学英语',
        '5' => '法语课程',
    ];

    // 搜索分类
    public $search_category = [
        '1' => ['11'=>'雅思','12'=>'托福','13'=>'语法'],
        '2' => ['21'=>'N1课程','22'=>'N2课程','23'=>'考研日语'],
        '3' => ['31'=>'求职课程'],
        '4' => ['41'=>'四级课程','42'=>'六级课程'],
        '5' => ['51'=>'法语课程'],
    ];

    /**
     * 搜素分类三级菜单
     */
    public  $search_category_three = [
        '11' => ['111'=>'英语四级','112'=>'英语六级','113'=>'考验英语','114'=>'专业英语'],
        '21' => ['211'=>'2英语四级','222'=>'2英语六级'],
        '31' => ['311'=>'3英语四级','322'=>'3英语六级'],
        '41' => ['411'=>'4英语四级','422'=>'4英语六级'],
        '51' => ['511'=>'5英语四级','522'=>'5英语六级'],
    ];


    /**
     * 课程分类图标
     */
     public  $category_icon = [
        '1' => 'icon-title-4.png',
        '2' => 'icon-title-5.png',
        '3' => 'icon-title-6.png',
        '4' => 'icon-title-7.png',
        '5' => 'icon-title-8.png',
    ];
    


    // 获得课程
    public function get_lesson(){
        $data = D2('DwCourseLesson')->select();
        return $res['data'] = $data;
    }


    // 获得课程-提供builder下拉
    public function get_lesson_builder(){
        $data = $this->get_lesson();
        foreach($data as $v){
            $kv[$v['id']] = $v['title'];
        }
        return $res['data'] = $kv;
    }

    /**
     *获取最新的课程
     */
     public function get_last_lesson(){
        $data=Db::table('dw_course_lesson')
           // ->where('satus','=',1)
            ->order('id desc')
            ->limit(4)
            ->select();
        return $data;
    }

    /**
     *获得课程报名人数
     */
     public function get_sgin_num($lesson_id){
        if(!$lesson_id)
        return false;
        // if(S('course_sgin_num_'.$lesson_id))
        //    return S('course_sgin_num_'.$lesson_id);
        $w['lesson_id'] = $lesson_id;
        $num = D2('DwSign')->where($w)->count();
        // 固定加50
        $num += 50;
        S('course_sgin_num_'.$lesson_id, $num ?:0 , 60 );
        return $num;
   }

   
    /**
     *获得课程特色
     */
     public function get_course_feature($lesson_id){
        if(!$lesson_id)
        return false;
        $w['id'] = $lesson_id;
        $info = D2('DwCourseLesson')->where($w)->find();
        $feature = explode(',', $info['feature']);
        $featrue_list= $this->get_feature();
        foreach($feature as $v){
            if($v && $featrue_list[$v])
                $new_list[] = $featrue_list[$v];
        }
        return $new_list;
   }

    // 获得特色
    public function get_feature($id=''){
        $list = D2('DwCourseFeature')->select();
        $new = make_k_v_array($list,'id','title');
        if($id)
        return $new[$id];
        return $new;
    }

    // 获得课程的信息
    public function get_course_info($info){
        $cache = S('course_lesson_info'.$info['id']);
        if($cache)
            return $cache;
        $id = $info['id'];
        
        $pic = API('Upload')->get_pic($info['img_1']);
        $info['img_1'] = '/uploads/' . $pic;
        $info['sign_num'] = API('Course')->get_sgin_num($id);
        $info['feature_list'] = API('Course')->get_course_feature($id);

        $lesson_type_list = explode(',', $info['lesson_type']);
        foreach($lesson_type_list as $v){
            if($v)
            $info['lesson_type_list'][] = API('Course')->lesson_type_index[$v];
        }
        
        if($info['book_1']){
            $pic = API('Upload')->get_pic($info['book_1']);
            $info['book_1'] = '/uploads/' . $pic;
        }
        
        $teacher_list = explode(',', $info['teacher']);
        $teachers = D2('DwTeacher')->select();
        foreach($teachers as $v){
            $pic = API('Upload')->get_pic($v['avatar']);
            $v['avatar'] = '/uploads/' . $pic;
            $t_list[$v['id']] = $v;
        }
        foreach($teacher_list as $v){
            if($v)
            $info['teacher_list'][] = $t_list[$v];
        }
        S('course_lesson_info'.$info['id'], $info , 60 );
        return $info;
    }

    


}
