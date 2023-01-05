<?php
namespace app\home\controller;
use nfutil\Page;
use think\Db;

/**
 * 前台默认控制器
 * 
 */
class Index extends Home
{


    /**
     * 默认方法
     * 
     */
    public function index(){

        if(is_wap())
        $this->redirect('wap/index');


        // 左侧导航
        foreach(API('Course')->search_category as $k => $v){
            $w8['category'] = array('like',$k.'%');
            $w8['status']=1;
            $nav_list[$k] = D2('DwCourseLesson')->where($w8)->limit(0,5)->select();
        }
        $this->assign('nav_list',$nav_list);
        

        // 热门课程
        $hot_course = API('Home')->get_hot_new_course('hot');
        $this->assign('hot_course',$hot_course);

        // 最新课程
        $new_course = API('Home')->get_hot_new_course('new');
        $this->assign('new_course',$new_course);

        // 获得轮播广告
        $top_ads = API('Home')->get_top_ads();
        $this->assign('top_ads',$top_ads);

        // 获得直播广告
        $zhibo_ads = API('Home')->get_zhibo_ads();
        $this->assign('zhibo_ads',$zhibo_ads);

        // 课程列表
        $course_list = API('Home')->get_home_course();
        $this->assign('course_list',$course_list);

        $this->display();
    }


    /**
     * 详情页面
     */
     public function detail()
     {
         $id=$this->request->param('id');
         if(!$id)
             $this->error('错误');
         $ip=$this->request->ip();
         API('Click')->click_num($id,'课程',$ip);
         if(is_wap())
             $this->redirect('wap/detail', ['id' => $id]);
         $data=Db::table('dw_course_lesson')->where('id','=',$id)->find();
          //获取特色信息
         $feature=explode(',',$data['feature']);
         foreach ($feature as $k=>$v){
                $data['feature_data'][$k]=API('Home')->get_feature($v);
         }
         //获取老师信息
         $teacher=explode(',',$data['teacher']);
         foreach ($teacher as $k=>$v){
             $data['teacher_data'][$k]=API('Home')->get_teacher($v);
         }
         if (!empty($data['img_1']))  $data['img_path']=API('upload')->get_pic($data['img_1']);
         if (!empty($data['book_1'])) $data['book_path']=API('upload')->get_pic($data['book_1']);
         //获得课程安排
         $data['lesson_schedule']=API('Home')->get_lesson_schedule($data['id']);
         $data['cat']=explode(',',$data['category']);
         $lesson_type_list = explode(',', $data['lesson_type']);
         foreach($lesson_type_list as $v){
             if($v)
                 $data['lesson_type_list'][] = API('Course')->lesson_type_index[$v];
         }
         //右侧相关课程查询
         $con_data=API('Home')->get_con_lesson($data['id'],$data['category']);
         $this->assign('con_lesson',$con_data);
         $this->assign('lesson_detail',$data);
         $this->display();
     }
 
 
    /**
     * 列表页
     * 
     */
     public function lesson_list(){
        $cat1 = I('cat1');
        $cat2 = I('cat2');
        $lesson_list = API('Home')->get_list_course($cat1, $cat2);
        $this->assign('lesson_list',$lesson_list);
        $this->display('list');
     }
 
 

    public function hot_course(){
        // 热门课程
        $hot_course = API('Home')->get_hot_new_course('hot');
        $this->assign('hot_course',$hot_course);
        $this->display();
    }


    public function zhibo_course(){

        // 获得直播广告
        $zhibo_ads = API('Home')->get_zhibo_course();
        $this->assign('zhibo_ads',$zhibo_ads);
        $this->display();
    }


    // 报名页
    public function sign(){

        if(request()->isPost()){
            if(!I('lesson_id'))
                $this->error('发生错误');
            if(!I('name'))
                $this->error('姓名');
            if(!I('weixin') && !I('qq') )
                $this->error('联系');
            if(!I('tel'))
                $this->error('手机');
            if(!preg_match("/^1[34578]{1}\d{9}$/",I('tel'))){
                $this->error('手机');
            }
            if(!I('phonecode'))
                $this->error('验证码');
            if (!$this->check_code(I('phonecode'))){
               $this->error('验证码');
            }
            // 同一课程，同一手机不能重复
            $w['lesson_id'] = I('lesson_id');
            $w['tel'] =I('tel');
            $info = D2('DwSign')->where($w)->find();
            if(!is_null($info))
                $this->error('请勿重复报名');
            $data['name'] = I('name');
            $data['weixin'] = I('weixin');
            $data['qq'] = I('qq');
            $data['tel'] = I('tel');
            $data['lesson_id'] = I('lesson_id');
            // $re = D2('DwSign')->add($data);
            $re = D2('DwSign')->add_sign($data);
            if($re)
                $this->success('成功');
        }

        if(!I('lesson_id'))
            $this->error('错误');
        $w5['id'] = I('lesson_id');
        $data = D2('DwCourseLesson')->where($w5)->find();
        $data = API('Course')->get_course_info($data);
        $this->assign('data', $data);
        $this->display();
    }


    // 报名成功页
    public function sign_success(){
        if(!I('id'))
            $this->error('错误');
        $w5['id'] = I('id');
        $data = D2('DwCourseLesson')->where($w5)->find();
        $data = API('Course')->get_course_info($data);
        $this->assign('data', $data);

        $this->display('success');
    }


}
