<?php
namespace app\home\controller;

class Wap extends  Home
{

    public function index()
    {

        // 获得轮播广告
        $top_ads = API('Home')->get_top_ads();
        $this->assign('top_ads',$top_ads);
        // 热门课程
        $hot_course = API('Home')->get_hot_new_course('hot');
        $this->assign('hot_course',$hot_course);

        // 最新课程
        $new_course = API('Home')->get_hot_new_course('new');
        $this->assign('new_course',$new_course);
        
        // 获得直播广告
        $zhibo_ads = API('Home')->get_zhibo_ads();
        $this->assign('zhibo_ads',$zhibo_ads);
        
        // 课程列表
        $course_list = API('Home')->get_home_course(1);
        $this->assign('course_list',$course_list);


        $this->display();
    }


    // 列表页
    public function listpage(){
        $category = I('category');
        if(!$category)
            $this->error('错误');
        $w['category'] = array('like', $category.'%');
        $w['status']=1;
        $list = D2('DwCourseLesson')->where($w)->order('sort desc')->select();
        $pics = API('Upload')->get_pic();
        foreach($list as $v){
            $v['img_1'] = '/uploads/'.$pics[$v['img_1']];
            $v['sign_num'] = API('Course')->get_sgin_num($v['id']);
            $new_list[] = $v;
        }
        // dump($list);
        $this->assign('list',$new_list);

        // 加载分类名和图标
        $this->assign('title',API('Course')->search_category_index[$category]);
        $this->assign('icon',API('Course')->category_icon[$category]);

        $this->display();
    }
    

    public function detail(){

        $id = I('id');
        if(!$id)
            $this->error('错误');

        $w['id'] = $id;
        $info = D2('DwCourseLesson')->where($w)->find();
        
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
        $info['lesson_schedule']=API('Home')->get_lesson_schedule($info['id']);
        $this->assign('info', $info);
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
            if($info)
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