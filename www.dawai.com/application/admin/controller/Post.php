<?php
namespace app\admin\controller;

use nfutil\Page;

/**
 * 文章控制器
 * 
 */
class Post extends Admin
{
    /**
     * 默认方法
     * 
     */
    public function index()
    {
        // 搜索
        $keyword         = I('keyword', '', 'string');
        $condition       = array('like', '%' . $keyword . '%');
        $map['id|title'] = array($condition, $condition, '_multi' => true);

        // 获取所有分类
        $p = I('p') ?: 1;
        if (I('cid')) {
            $cid = $map['cid'] = I('cid');
        }
        $map['status'] = array('egt', '0'); // 禁用和正常状态
        $post_object   = D2('AdminPost');
        $data_list     = $post_object
            ->page($p, C('ADMIN_PAGE_ROWS'))
            ->where($map)
            ->order('sort desc,id desc')
            ->select();
        $page = new Page(
            $post_object->where($map)->count(),
            C('ADMIN_PAGE_ROWS')
        );

        // 使用Builder快速建立列表页面
        $builder = new \nfutil\builder\ListBuilder();
        $builder->setMetaTitle('文章列表') // 设置页面标题
            ->addTopButton('self', array( // 添加返回按钮
                'title'   => '<i class="fa fa-reply"></i> 返回导航列表',
                'class'   => 'btn btn-warning-outline btn-pill',
                'onclick' => 'javascript:history.back(-1);return false;')
            )
            ->addTopButton('addnew', array('href' => U('add', array('cid' => $cid)))) // 添加新增按钮
            ->addTopButton('resume') // 添加启用按钮
            ->addTopButton('forbid') // 添加禁用按钮
            ->setSearch('请输入ID/标题', U('index'))
            ->addTableColumn('id', 'ID')
            ->addTableColumn('cover', '封面', 'picture')
            ->addTableColumn('title', '标题')
            ->addTableColumn('create_time', '创建时间', 'time')
            ->addTableColumn('sort', '排序')
            ->addTableColumn('status', '状态', 'status')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($data_list) // 数据列表
            ->setTableDataPage($page->show()) // 数据列表分页
            ->addRightButton('edit') // 添加编辑按钮
            ->addRightButton('forbid') // 添加禁用/启用按钮
            ->addRightButton('delete') // 添加删除按钮
            ->display();
    }

    /**
     * 新增文档
     * 
     */
    public function add($cid)
    {
        if (request()->isPost()) {
            $post_object = D2('AdminPost');
            $data        = $post_object->create(format_data());
            if ($data) {
                $id = $post_object->add();
                if ($id) {
                    $this->success('新增成功', U('index', array('cid' => $cid)));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($post_object->getError());
            }
        } else {
            // 使用FormBuilder快速建立表单页面
            $builder = new \nfutil\builder\FormBuilder();
            $builder->setMetaTitle('新增文章') // 设置页面标题
                ->setPostUrl(U('add')) // 设置表单提交地址
                ->addFormItem('cid', 'hidden', '分类', '分类')
                ->addFormItem('title', 'text', '标题', '标题')
                ->addFormItem('abstract', 'textarea', '摘要', '摘要')
                ->addFormItem('content', 'kindeditor', '内容', '内容')
                ->addFormItem('cover', 'picture', '封面', '封面')
                ->addFormItem('create_time', 'datetime', '发布时间', '发布时间')
                ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                ->setFormData(array('cid' => $cid))
                ->display();
        }
    }

    /**
     * 编辑文章
     * 
     */
    public function edit($id)
    {
        if (request()->isPost()) {
            $post_object = D2('AdminPost');
            $data        = $post_object->create(format_data());
            if ($data) {
                $id = $post_object->save();
                if ($id !== false) {
                    $this->success('更新成功', U('index'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($post_object->getError());
            }
        } else {
            // 使用FormBuilder快速建立表单页面
            $builder = new \nfutil\builder\FormBuilder();
            $builder->setMetaTitle('编辑文章') // 设置页面标题
                ->setPostUrl(U('edit')) // 设置表单提交地址
                ->addFormItem('id', 'hidden', 'ID', 'ID')
                ->addFormItem('title', 'text', '标题', '标题')
                ->addFormItem('abstract', 'textarea', '摘要', '摘要')
                ->addFormItem('content', 'kindeditor', '内容', '内容')
                ->addFormItem('cover', 'picture', '封面', '封面')
                ->addFormItem('create_time', 'datetime', '发布时间', '发布时间')
                ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                ->setFormData(D2('AdminPost')->find($id))
                ->display();
        }
    }
}
