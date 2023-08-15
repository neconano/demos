<?php
namespace app\sign\admin;
use app\admin\controller\Admin;
use nfutil\Page;

/**
 * 后台文档模型控制器
 * 
 */
class Baoming extends Admin {
    /**
     * 模型列表
     * 
     */
    public function index() {
        // 备注
        if(I('dotype') == 'remark' || I('dotype') == 'remark_2'){
            if(!I('id'))
                $this->error("发生错误");
            $w['id'] = I('id');
            if(I('remark'))
                $data['remark'] = I('remark');
            if(I('remark_2'))
                $data['remark_2'] = I('remark_2');
            $re = D2('DwSign')->where($w)->save($data);
            if($re !== false)
            $this->success("成功");
            $this->error("内容不存在");
        }

        // 搜索
        $keyword = I('keyword', '', 'string');
        if($keyword){
            $condition = array('like','%'.$keyword.'%');
            $map['id'] = array($condition, $condition, $condition,'_multi'=>true);
        }

        if(I('s_cat1')){
            if(I('s_cat2'))
            $map['category_id'] = I('s_cat1').','.I('s_cat2') ;
            else
            $map['category_id'] = array('like',I('s_cat1').'%') ;
        }

        // 获取所有模型
        $data_list = D2('DwSign')
                   ->page(!empty(I('p'))?I('p'):1, C('ADMIN_PAGE_ROWS'))
                   ->where($map)
                   ->order('id desc')
                   ->select();
        $page = new Page(D2('DwSign')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        // 使用Builder快速建立列表页面。
        $builder = new \nfutil\builder\ListBuilder();
        // 设置搜索页
        $listbuilder = APP_PATH . strtolower(request()->module()) . '/view/admin/baoming/index.html';
        $builder->setMetaTitle('模型列表')  // 设置页面标题
                ->addTopButton('self', ['title'=>'已处理','href'=>'set_deal','class'=>'btn btn-danger-outline btn-pill ajax-post confirm'])  
                ->setSearch('请输入ID/模型标题', U('index'))
                ->addTableColumn('name', '称呼')
                ->addTableColumn('tel', '电话')
                ->addTableColumn('weixin', '微信')
                ->addTableColumn('qq', 'QQ')
                ->addTableColumn('lesson_title', '课程')
                ->addTableColumn('category_title', '所属类别')
                ->addTableColumn('create_time', '时间', 'time')
                ->addTableColumn('remark', '备注')
                ->addTableColumn('right_button', '状态', 'btn')
                ->setTableDataList($data_list)     // 数据列表
                ->setTableDataPage($page->show())  // 数据列表分页
                ->addRightButton('self',['type'=>'self'])           // 添加编辑按钮
                ->setTemplate('builder/list_baoming')
                ->display('',['_listbuilder_layout'=>$listbuilder]);
    }

    // 设置已处理
    public function set_deal() {
        $this->error("功能未启用");
    }
        


}
