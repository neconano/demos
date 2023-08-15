<?php
namespace app\course\admin;
use app\admin\controller\Admin;
use nfutil\Db;
use nfutil\Page;

/**
 * 课程
 * 
 */
class Lesson extends Admin {

    /**
     * 课程列表
     *
     */
    public function index() {
        // 搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title'] = array($condition, $condition, $condition,'_multi'=>true);

        if(I('s_cat1')){
            if(I('s_cat2'))
            $map['category'] = I('s_cat1').','.I('s_cat2') ;
            else
            $map['category'] = array('like',I('s_cat1').'%') ;
        }
        //排序
        if (I('dotype')=='sort'){
            if(!I('id'))
                $this->error("发生错误");
            $data['sort']=I('post.sort');
            $w['id'] = I('id');
            $re = D2('DwCourseLesson')->where($w)->save($data);
            if($re !== false)
                $this->success("成功");
            $this->error("排序失败");
        }
        if (I('s_new')){
            $map['is_new']=I('s_new');
        }
        if (I('hot')){
            $map['is_hot']=I('hot');
        }
        $map['status'] = array('egt', '0');  // 禁用和正常状态
        $data_list = D2('DwCourseLesson')
                   ->page(!empty(I('p'))?I('p'):1, C('ADMIN_PAGE_ROWS'))
                   ->where($map)
                   ->order('sort desc, id desc')
                   ->select();

        foreach ($data_list as $k=>$v){
            $data_list[$k]['click']=API('Click')->get_click_num($v['id'],'课程');
        }
        $page = new Page(D2('DwCourseLesson')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        // 使用Builder快速建立列表页面。
        $builder = new \nfutil\builder\ListBuilder();
        // 设置搜索页
        $listbuilder = APP_PATH . strtolower(request()->module()) . '/view/admin/lesson/index.html';

        // 设置最热按钮
        $hot['model']                   = 'dw_course_lesson';
        $hot['name']                    = 'set_hot';
        $hot['title']                   = '热门';
        $hot['callback']                = 'set_course_hot';
        $hot[$hot['name'].'0']['name']  = $new['name'];
        $hot[$hot['name'].'0']['title'] = '设置最热';
        $hot[$hot['name'].'0']['class'] = 'label label-success-outline label-pill ajax-get confirm';
        $hot[$hot['name'].'0']['href']  = url('set_new_hot',['id'=>'__data_id__','set_type'=>'hot']);
        $hot[$hot['name'].'1']['name']  = $new['name'];
        $hot[$hot['name'].'1']['title'] = '取消最热';
        $hot[$hot['name'].'1']['class'] = 'label label-warning-outline label-pill ajax-get confirm';
        $hot[$hot['name'].'1']['href']  = url('set_new_hot',['id'=>'__data_id__','set_type'=>'hot']);
        // 设置最新按钮
        $new['model']                   = 'dw_course_lesson';
        $new['name']                    = 'set_new';
        $new['title']                   = '最新';
        $new['callback']                = 'set_course_new';
        $new[$new['name'].'0']['name']  = $new['name'];
        $new[$new['name'].'0']['title'] = '设置最新';
        $new[$new['name'].'0']['class'] = 'label label-success-outline label-pill ajax-get confirm';
        $new[$new['name'].'0']['href']  = url('set_new_hot',['id'=>'__data_id__','set_type'=>'new']);
        $new[$new['name'].'1']['name']  = $new['name'];
        $new[$new['name'].'1']['title'] = '取消最新';
        $new[$new['name'].'1']['class'] = 'label label-warning-outline label-pill ajax-get confirm';
        $new[$new['name'].'1']['href']  = url('set_new_hot',['id'=>'__data_id__','set_type'=>'new']);



        $builder->setMetaTitle('模型列表')  // 设置页面标题
            ->addTopButton('addnew')    // 添加新增按钮
            ->addTopButton('resume')  // 添加启用按钮
            ->addTopButton('forbid')  // 添加禁用按钮
            ->setSearch('请输入ID/模型标题', U('index'))
            ->addTableColumn('id', 'ID')
            ->addTableColumn('title', '标题')
            ->addTableColumn('create_time', '创建时间', 'time')
            ->addTableColumn('click','点击量')
            ->addTableColumn('sort', '排序','','','10%')
            ->addTableColumn('status', '状态', 'status')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($data_list)     // 数据列表
            ->setTableDataPage($page->show())  // 数据列表分页
            ->addRightButton('edit',['href'=>url('add',['id'=>'__data_id__'])])           // 添加编辑按钮
            ->addRightButton('forbid', ['model'=>'dw_course_lesson'])  // 添加禁用/启用按钮
            ->addRightButton('self',['name'=>'schedule','title'=>'课程安排','href'=>url('schedule_manage',['lesson_id'=>'__data_id__'])])
            ->addRightButton('self',$hot)
            ->addRightButton('self',$new)
            ->setTemplate('builder/list_course')
            ->display('',['_listbuilder_layout'=>$listbuilder]);
    }

    // 设置最热
    public function set_new_hot($id,$set_type){
        if(!$id || !$set_type)
            $this->error('错误');
        $w['id'] = $id;
        $lesson = D2('DwCourseLesson')->where($w)->find();
        if($set_type == 'hot')
        $data['is_hot'] = $lesson['is_hot'] == 1 ? 0 : 1;
        if($set_type == 'new')
        $data['is_new'] = $lesson['is_new'] == 1 ? 0 : 1;
        D2('DwCourseLesson')->where($w)->save($data);
        $this->success('成功');
    }


    /**
     * 新增课程列表
     */
    public function add($id='')
    {
        $lesson = D2('DwCourseLesson');
        if ($this->request->isPost()){
            $data=$this->request->Post();
            $res= $lesson->do_add($data);
            if ($res['status']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }else{
            $res = $lesson->do_get($id);

            // 使用FormBuilder快速建立表单页面
            $builder = new \nfutil\builder\FormBuilder();
            // 设置表单页
            $formbuilder = APP_PATH . strtolower(request()->module()) . '/view/admin/lesson/formbuilder.html';
            $builder->setMetaTitle('新增配置') //设置页面标题
                ->setPostUrl(U('add')) //设置表单提交地址
                ->addFormItem('id', 'hidden', 'ID', 'ID')
                ->addFormItem('title', 'text', '课程标题', '请输入标题')
                ->addFormItem('lesson_flag', 'text', '标签', '请输入标题')
                ->addFormItem('img_1', 'picture', '课程图片', '课程图片')
                ->addFormItem('description', 'text', '课程描叙', '请输入课程描叙')
                ->addFormItem('cost', 'text', '课程价格', '请输入课程价格')
                ->addFormItem('prime_cost', 'text', '课程原价', '请输入课程原价')
                ->addFormItem('total_hour', 'text', '课时总数', '请输入课时总数')
                ->addFormItem('suit_people', 'textarea', '适合人群', '请输入适合人群')
                ->addFormItem('feature', 'feature', '课程特色','' , $res['feature'])
                ->addFormItem('category', 'category', '课程分类')
                ->addFormItem('lesson_type', 'checkbox', '授课方式','', API('Course')->lesson_type_index )
                ->addFormItem('end_time', 'text', '有效日期', '请输入有效日期')
                ->addFormItem('coures_content', 'kindeditor', '课程简介', '请输入课程简介')
                ->addFormItem('study_target', 'kindeditor', '学习目标', '请输入学习目标')
                ->addFormItem('book_1', 'picture', '推荐教材', '推荐教材')
                ->addFormItem('book_description', 'text', '推荐教材', '推荐教材')
                ->addFormItem('teacher', 'teacher', '授课老师', '', $res['teacher'])
                ->addFormItem('sort', 'text', '排序')
                ->setFormData($res['info'])
                ->setTemplate('builder/form_course')
                ->display('',['_formbuilder_layout'=>$formbuilder]);
        }

    }


    // 排课
    public function  schedule_manage(){

        // 准备新增大类
        if(I('dotype') == 'new_widget_0'){
            if(!I('lesson_id'))
            $this->error('错误');
            echo $this->fetch('widget_0');
            exit;
        }

        // 新增大类
        if(I('dotype') == 'add_widget_0'){
            $data['title'] = I('title');
            $data['hour'] = I('total_hour');
            $data['lesson_id'] = I('lesson_id');
            $data['category'] = I('lesson_type');
            $id = D2('DwCourseLessonSchedule')->add($data);
            if($id){
                $data['id'] = $id;
                $this->assign('info',$data);
                echo $this->fetch('widget_1');
                exit;
            }else{
                $this->error('错误');
            }
        }

        // 修改/删除大类
        if(I('dotype') == 'save_widget_1' || I('dotype') == 'del_widget_1' ){
            $data['title'] = I('title');
            $data['hour'] = I('total_hour');
            $w55['id'] = I('id');
            if(I('dotype') == 'save_widget_1'){
                $re = D2('DwCourseLessonSchedule')->where($w55)->save($data);
            }
            if(I('dotype') == 'del_widget_1'){
                // 内容列表必须为空
                $w99['pid'] = I('id');
                $list_pid = D2('DwCourseLessonSchedule')->where($w99)->select();
                if($list_pid)
                $this->error('内容列表必须为空');
                $re = D2('DwCourseLessonSchedule')->where($w55)->delete();
            }
            if($re !== false)
            $this->success('成功');
            $this->error('错误');
        }

        // 准备新增内容
        if(I('dotype') == 'new_widget_2'){
            if(!I('pid'))
            $this->error('错误');
            $this->assign('pid',I('pid'));
            echo $this->fetch('widget_2');
            exit;
        }

        // 新增内容
        if(I('dotype') == 'add_widget_2'){
            $w33['id'] = I('pid');
            $info33 = D2('DwCourseLessonSchedule')->where($w33)->find();
            if(!$info33)
                $this->error('错误2002');
            $data['title'] = I('title');
            $data['pid'] = I('pid');
            $id = D2('DwCourseLessonSchedule')->add($data);
            if($id){
                $data['id'] = $id;
                $this->assign('info',$data);
                echo $this->fetch('widget_3');
                exit;
            }
            $this->error('错误');
        }

        // 修改/删除/内容
        if(I('dotype') == 'save_widget_3' || I('dotype') == 'del_widget_3' ){
            if(!I('id'))
                $this->error('错误2012');
            $w11['id'] = I('id');
            if(I('dotype') == 'save_widget_3'){
                $data['title'] = I('title');
                $re = D2('DwCourseLessonSchedule')->where($w11)->save($data);
            }
            if(I('dotype') == 'del_widget_3'){
                $re = D2('DwCourseLessonSchedule')->where($w11)->delete();
            }
            if($re !== false)
            $this->success('成功');
            $this->error('错误');
        }



        // 获得课程安排列表
        $w22['id'] = I('lesson_id');
        $info = D2('DwCourseLesson')->where($w22)->find();
        if(!$info )
            $this->error('错误2001','/admin.php');
        $lesson_type_list = [2,3];
        $this->assign('lesson_type_list',$lesson_type_list);
        // 调整跳转
        if(!I('lesson_type')){
            $this->redirect('course/lesson/schedule_manage','lesson_type='.$lesson_type_list[0].'&lesson_id='.I('lesson_id') );
        }
        $this->assign('lesson_type',I('lesson_type'));

        if(!I('lesson_id'))
        $this->error('错误','/admin.php');
        $w['lesson_id'] = I('lesson_id');
        $w['category'] = I('lesson_type');
        $w['pid'] = array('eq', 0);
        $list = D2('DwCourseLessonSchedule')->where($w)->select();

        foreach($list as $v){
            // 获得内容
            $w_2_list = '';
            $w2['pid'] = $v['id'];
            $list2 = D2('DwCourseLessonSchedule')->where($w2)->order('id asc')->select();
            foreach($list2 as $v2){
                $this->assign('info',$v2);
                $w_2_list[] = $this->fetch('widget_3');
            }
            $this->assign('w_2_list',$w_2_list);

            $this->assign('info',$v);
            $w_1_list[] = $this->fetch('widget_1');
        }
        $this->assign('w_1_list',$w_1_list);



        $this->display('schedule_manage');


    }



}
