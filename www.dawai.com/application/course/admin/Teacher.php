<?php
namespace app\course\admin;
use app\admin\controller\Admin;
use nfutil\Page;

/**
 * 教师
 * 
 */
class Teacher extends Admin {

    /**
     * 课程列表
     * 
     */
    public function index() {
        // 搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title'] = array($condition, $condition, $condition,'_multi'=>true);
        $map['status'] = array('egt', '0');  // 禁用和正常状态
        $data_list = D2('DwTeacher')
                   ->page(!empty(I('p'))?I('p'):1, C('ADMIN_PAGE_ROWS'))
                   ->where($map)
                   ->order('id desc')
                   ->select();
        $page = new Page(D2('DwTeacher')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        // 使用Builder快速建立列表页面。
        $builder = new \nfutil\builder\ListBuilder();
        $builder->setMetaTitle('模型列表')  // 设置页面标题
                ->addTopButton('addnew')    // 添加新增按钮
                ->addTopButton('resume', array('model' => 'dw_teacher') ) // 添加启用按钮
                ->addTopButton('forbid', array('model' => 'dw_teacher') ) // 添加禁用按钮
                ->setSearch('请输入ID/模型标题', U('index'))
                ->addTableColumn('id', 'ID')
                ->addTableColumn('title', '标题')
                ->addTableColumn('sort', '排序')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list)     // 数据列表
                ->setTableDataPage($page->show())  // 数据列表分页
                ->addRightButton('edit')           // 添加编辑按钮
                ->addRightButton('forbid', array('model' => 'dw_teacher') )  // 添加禁用/启用按钮
                ->display();
    }


    public function add()
    {
        if (request()->isPost()) {
            $config_object = D2('DwTeacher');
            $data          = $config_object->create();
            if ($data) {
                if ($config_object->add($data)) {
                    $this->success('新增成功', U('index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($config_object->getError());
            }
        } else {
            // 使用FormBuilder快速建立表单页面
            $builder = new \nfutil\builder\FormBuilder();
            $builder->setMetaTitle('新增配置') //设置页面标题
                ->setPostUrl(U('add')) //设置表单提交地址
                ->addFormItem('title', 'text', '老师名', '老师名')
                ->addFormItem('description', 'textarea', '老师介绍', '老师介绍')
                ->addFormItem('avatar', 'picture', '头像', '头像')
                ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                ->display();
        }
    }
    

    /**
     * 编辑
     * 
     */
     public function edit($id)
     {
         if (request()->isPost()) {
             // 提交数据
             $user_object = D2('DwTeacher');
             $data        = $user_object->create();
             if ($data) {
                 $result = $user_object
                     ->save($data);
                 if ($result) {
                     $this->success('更新成功', U('index'));
                 } else {
                     $this->error('更新失败', $user_object->getError());
                 }
             } else {
                 $this->error($user_object->getError());
             }
         } else {
             $info = D2('DwTeacher')->find($id);
             // 使用FormBuilder快速建立表单页面
             $builder = new \nfutil\builder\FormBuilder();
             $builder->setMetaTitle('编辑用户') // 设置页面标题
                 ->setPostUrl(U('edit')) // 设置表单提交地址
                 ->addFormItem('id', 'hidden', 'ID', 'ID')
                 ->addFormItem('title', 'text', '老师名', '老师名')
                 ->addFormItem('description', 'textarea', '老师介绍', '老师介绍')
                 ->addFormItem('avatar', 'picture', '头像', '头像')
                 ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                  ->setFormData($info)
                 ->display();
         }
     }
 






}
