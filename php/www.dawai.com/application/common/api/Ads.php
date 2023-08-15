<?php
namespace app\common\api;
use app\common\api\Base;
use nfutil\Page;
/**
 * 广告
 */
class Ads extends Base
{   

    public function index($where='') {
        // 搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title'] = array($condition, $condition, $condition,'_multi'=>true);
        $map['status'] = array('egt', '0');  // 禁用和正常状态
        $map = array_merge($map, $where);
        $data_list = D2('DwAds')
                   ->page(!empty(I('p'))?I('p'):1, C('ADMIN_PAGE_ROWS'))
                   ->where($map)
                   ->order('id desc')
                   ->select();
        $page = new Page(D2('DwAds')->where($map)->count(), C('ADMIN_PAGE_ROWS'));

        // 使用Builder快速建立列表页面。
        $builder = new \nfutil\builder\ListBuilder();
        $builder->setMetaTitle('模型列表')  // 设置页面标题
                ->addTopButton('addnew')    // 添加新增按钮
                ->addTopButton('resume', array('model' => 'dw_ads') ) // 添加启用按钮
                ->addTopButton('forbid', array('model' => 'dw_ads') ) // 添加禁用按钮
                ->setSearch('请输入ID/模型标题', U('index'))
                ->addTableColumn('id', 'ID')
                ->addTableColumn('title', '标题')
                ->addTableColumn('sort', '排序')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list)     // 数据列表
                ->setTableDataPage($page->show())  // 数据列表分页
                ->addRightButton('edit')           // 添加编辑按钮
                ->addRightButton('forbid', array('model' => 'dw_ads') )  // 添加禁用/启用按钮
                ->alterTableData(  // 修改列表数据
                    array('key' => 'system', 'value' => '1'),
                    array('right_button' => $right_button)
                )
                ->display();
    }
    

    /**
     * 新增
     * 
     */
     public function add($category=1)
     {
         if (request()->isPost()) {
             $res['status'] = false;
             $slider_object = D2('DwAds');
             $post = I('post.');
             $post['content'] = serialize($post);
             $data          = $slider_object->create($post);
             if ($data) {
                 $id = $slider_object->add();
                 if ($id) {
                    $res['status'] = true;
                    $res['msg'] = '新增成功';
                 } else {
                     $res['msg'] = '新增失败';
                 }
            } else {
                $res['msg'] = $slider_object->getError();
            }
            return $res;
        } else {
            $info['category'] = $category;
            // 使用FormBuilder快速建立表单页面
            $builder = new \nfutil\builder\FormBuilder();
            $builder = $builder
                        ->setMetaTitle('新增') // 设置页面标题
                        ->setPostUrl(U('add')) // 设置表单提交地址
                        ->addFormItem('category', 'hidden', '分类', '分类')
                        ->addFormItem('title', 'text', '标题', '标题')
                        ->addFormItem('cover', 'picture', '图片', '切换图片')
                        ->addFormItem('cover_wap', 'picture', '手机端图片', '切换图片')
                        ->setFormData($info);
            if($info['category'] == 2){
                $builder = $builder
                            ->addFormItem('lesson_id', 'select', '课程', '课程', API('Course')->get_lesson_builder() )
                            ->addFormItem('zhibo_time', 'text', '直播时间', '直播时间')
                            ->addFormItem('flag', 'text', '标签', '标签');
            }else{
                $builder = $builder
                            ->addFormItem('start_time', 'date', '开始时间', '开始时间')
                            ->addFormItem('end_time', 'date', '结束时间', '结束时间')
                            ->addFormItem('url', 'text', '链接', '点击跳转链接');
           }
           $builder->addFormItem('sort', 'num', '排序', '用于显示的顺序')->display();
           exit;

        }
     }
 

    /**
     * 编辑
     * 
     */
     public function edit($id,$category=1)
     {
         if (request()->isPost()) {
            $res['status'] = false;
            // 提交数据
            $user_object = D2('DwAds');

            $post = I('post.');
            $post['content'] = serialize($post);
            
            $data        = $user_object->create($post);
            if ($data) {
                $result = $user_object->save($data);
                if ($result) {
                    $res['status'] = true;
                    $res['msg'] = '更新成功';
                } else {
                    $res['msg'] = '更新失败';
                }
            } else {
                $res['msg'] = $slider_object->getError();
            }
            return $res;
        } else {
            $info = D2('DwAds')->find($id);
            $content = unserialize($info['content']);
            $info['lesson_id'] = $content['lesson_id'];
            $info['zhibo_time'] = $content['zhibo_time'];
            
            // 使用FormBuilder快速建立表单页面
            $builder = new \nfutil\builder\FormBuilder();
            $builder = $builder
                        ->setMetaTitle('更新') // 设置页面标题
                        ->setPostUrl(U('edit')) // 设置表单提交地址
                        ->addFormItem('id', 'hidden', 'ID', 'ID')
                        ->addFormItem('title', 'text', '标题', '标题')
                        ->addFormItem('cover', 'picture', '图片', '切换图片')
                        ->addFormItem('cover_wap', 'picture', '手机端图片', '切换图片')
                        ->setFormData($info);
            if($info['category'] == 2){
                $builder = $builder
                            ->addFormItem('lesson_id', 'select', '课程', '课程', API('Course')->get_lesson_builder() )
                            ->addFormItem('zhibo_time', 'text', '直播时间', '直播时间')
                            ->addFormItem('flag', 'text', '标签', '标签');
            }else{
                $builder = $builder
                            ->addFormItem('start_time', 'date', '开始时间', '开始时间')
                            ->addFormItem('end_time', 'date', '结束时间', '结束时间')
                            ->addFormItem('url', 'text', '链接', '点击跳转链接');
           }
           $builder->addFormItem('sort', 'num', '排序', '用于显示的顺序')->display();
           exit;

        }

     }














}
