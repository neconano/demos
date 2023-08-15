<?php
namespace app\common\api;
use app\common\api\Base;
use think\Db;

/**
 * 展示
 */
class Home extends Base
{   

    // 获得课程
    public function get_lesson(){
        $data = D2('DwCourseLesson')->order('sort desc')->select();
        foreach ($data as $k=>$v){
            if (!empty($v['img_1'])){
                $data[$k]['img_path']=API('upload')->get_pic($v['img_1']);
            }
            if (!empty($v['book_1'])){
                $data[$k]['book_path']=API('upload')->get_pic($v['book_1']);
            }
        }

        // 按分类归类
        $lesson_type_index = API('Course')->search_category_index;
        foreach($lesson_type_index as $k => $v){
            foreach($data as $vol){
                $category = explode(',', $vol['category']);
                if( in_array($k, $category) ){
                    $new[$k][] = $vol;
                }
            }
        }

        return $res['data'] = $data;
    }

    /**
     * 获取特色
     * @param string $id
     * @return mixed
     */
    public function get_feature($id=''){
        $list = Db::table('dw_course_feature')->find($id);
        return $list;
    }

    /**默认获取老师信息和图片地址
     * @param string $id
     * @param bool $teacher
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function get_teacher($id='',$teacher=true){
        $list = Db::table('dw_teacher')->find($id);
        if ($teacher&&!empty($list['avatar'])){
            $list['teacher_path']=API('upload')->get_pic($list['avatar']);
        }
        return $list;
    }

    /**查询类别相同的课程
     * @param $id
     * @param $catagory
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_con_lesson($id,$category){

        $list =Db::table('dw_course_lesson')
                ->where('category','=',$category)
                ->where('id','<>',$id)
                ->limit(3)
                ->select();
        foreach ($list as $k=>$v){
            $list[$k]['img_path'] =API('upload')->get_pic($v['img_1']);
        }
        return $list;
    }

    // 获得首页课程列表
    function get_home_course($iswap=0){
        foreach(API('Course')->search_category_index as $k=>$v ){
            $w5['category'] = array('like',$k.'%');
            $w5['status'] = 1;
            $num = $k == 1 ?8:4;
            if($iswap) 
            $num = 4;
            $list = D2('DwCourseLesson')->where($w5)->order('sort desc')->limit(0,$num)->select();
            foreach($list as $v){
                $course_list[$k][] = API('Course')->get_course_info($v);
            }
        }
        return $course_list;
    }

    /**
     * 获取直播课程
     * @return array
     *
     */
    public function  get_zhibo_course()
    {
        $w3['category'] = 2;
        $w3['status'] = 1;
        $list = D2('DwAds')->where($w3)->order('sort desc')->select();
        foreach($list as $v){
            $content = unserialize($v['content']);
            $w33['id'] = $content['lesson_id'];
            $course = D2('DwCourseLesson')->where($w33)->find();
            $course['img_path'] =API('upload')->get_pic($course['img_1']);
            $course['sign_num'] = API('Course')->get_sgin_num($course['id']);
            $v['course'] = $course;
            $zhibo_ads[] = $v;
        }
        return $zhibo_ads;
    }
    // 直播广告
    function get_zhibo_ads(){
        $w3['category'] = 2;
        $w3['status'] = 1;
        $list = D2('DwAds')->where($w3)->limit(0,3)->select();
        foreach($list as $v){
            if($v['cover_wap'])
            $v['cover_wap'] = '/uploads/'.API('Upload')->get_pic($v['cover_wap']);
            if($v['cover'])
            $v['cover'] = '/uploads/'.API('Upload')->get_pic($v['cover']);
            $content = unserialize($v['content']);
            $v['zhibo_time'] = $content['zhibo_time'];
            if($content['lesson_id']){
                $w33['id'] = $content['lesson_id'];
                $course = D2('DwCourseLesson')->where($w33)->find();
            }
            $course['sign_num'] = API('Course')->get_sgin_num($course['id']);
            $v['course'] = $course;
            $zhibo_ads[] = $v;
        }
        return $zhibo_ads;
    }


    // 获得轮播广告
    function get_top_ads(){
        $w3['category'] = 1;
        $w3['status'] = 1;
        $list = D2('DwAds')->where($w3)->select();
        foreach($list as $v){
            if($v['cover'])
            $v['cover'] = '/uploads/'.API('Upload')->get_pic($v['cover']);
            if($v['cover_wap'])
            $v['cover_wap'] = '/uploads/'.API('Upload')->get_pic($v['cover_wap']);
            $top_ads[] = $v;
        }
        return $top_ads;
    }        



    // 直播广告
    function get_hot_new_course($category='hot'){
        if($category == 'hot') $w['is_hot'] = 1;
        if($category == 'new')$w['is_new'] = 1;
        $w['status'] = 1;
        $num = 8;
        $list = D2('DwCourseLesson')->where($w)->order('sort desc')->limit(0,$num)->select();
        $hot_course = [];
        foreach($list as $v){
            $hot_course[] = API('Course')->get_course_info($v);
        }
        return $hot_course;
    }

    /**
     * 获得课程安排
     * @param string $id  课程id
     * @return mixed
     */
    public function  get_lesson_schedule($id=''){
        $where['lesson_id']=$id;
        $where['pid']=0;
        $list = Db::table('dw_course_lesson_schedule')->where($where)->select();
        $list_up=[];
        $list_down=[];
        foreach ($list as $k=>$v){
            if ($v['category']==2){
                $list_up[$v['id']]=$v;
                $childen=Db::table('dw_course_lesson_schedule')->where('pid','=',$v['id'])->select();
                foreach ($childen as $key=>$value) {
                    $list_up[$v['id']]['childen'][$key] = $value;
                }
            }
            if ($v['category']==3) {
                $list_down[$v['id']]=$v;
                $childen=Db::table('dw_course_lesson_schedule')->where('pid','=',$v['id'])->select();
                foreach ($childen as $key=>$value){
                    $list_down[$v['id']]['childen'][$key]=$value;
                }
            }

        }
        $arr['up']=$list_up;
        $arr['down']=$list_down;
        return $arr;
    }



    // 获得指定分类课程
    function get_list_course($cat1, $cat2=''){
        if($cat1 && $cat2)
        $w5['category'] = array('like',$cat1.','.$cat2);
        else{
            if($cat1)
            $w5['category'] = array('like',$cat1.'%');
            if($cat2)
            $w5['category'] = array('like','%'.$cat2);
        }
        $w5['status'] = 1;
        $list = D2('DwCourseLesson')->where($w5)->order('sort desc')->select();
        
        foreach($list as $v){
            $course_list[] = API('Course')->get_course_info($v);
        }
        return $course_list;
    }




}
