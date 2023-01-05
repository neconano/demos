<?php
namespace app\home\admin;
use app\admin\controller\Admin;
use nfutil\builder\ListBuilder;
use nfutil\builder\FormBuilder;

class Index extends Admin {

    // 开启/禁用
    public function model2status(){
        $data['status'] = I('type');
        $res['status'] = false;
        $res['msg'] = '勾选后操作';
        if($_POST['ids']){
            $ids = \implode(',',$_POST['ids']) ;
            $www['id'] = array('in',$ids);
            $id = D2(I('model'))->where($www)->save($data);
            $res['status'] = true;
            $res['msg'] = '完成';
        }
        if(I('id')){
            $www['id'] = I('id');
            $id = D2(I('model'))->where($www)->save($data);
            $res['status'] = true;
            $res['msg'] = '完成';
        }
        // 优惠券
        if(I('model') == 'cf_coupon'){
            $w3ww['coupon_id'] = array('in',$ids);
            M('cf_customer_coupon',null)->where($w3ww)->save($data);
        }
        // 账目
        if(I('model') == 'cf_user_money_record'){
            $www['id'] = I('id');
            $data = D2(I('model'))->where($www)->find();
            if($data['opt_type'] == '提现'){
                $res['status'] = false;
                $res['msg'] = '提现禁止删除';
                $this->std_return($res);
            }
            API('Coffee')->_recount_user_money($data['uid']);
        }
        $this->std_return($res);
    }

    // 兑换码
    public function free_code_list() {
        $getRes = API('Coffee')->get_free_code(['device_id'=>I('id')]);
        $builder = new ListBuilder();
        $builder->setMetaTitle('兑换码');  // 设置页面标题
            // ->addTopButton('addnew', array('href' => U('make_free_code',['device_id'=>I('id')]))); // 添加新增按钮
        $builder
            ->addTableColumn('id', 'ID')
            ->addTableColumn('code', '兑换码')
            ->addTableColumn('device_id', '设备ID')
            ->addTableColumn('device_number', '设备号')
            ->addTableColumn('start_time', '开始时间')
            ->addTableColumn('end_time', '结束时间')
            ->addTableColumn('is_used', '是否使用', 'status')
            ->setTableDataList($getRes['data'])     // 数据列表
            ->setTableDataPage($getRes['page']->show())  // 数据列表分页
            ->display();
    }

    // 兑换码
    public function make_free_code() {
        if (request()->isPost()) {
            $getRes = API('Coffee')->make_free_code(I('post.'));
            $this->std_return($getRes);
        }
        $data['device_id'] = I('device_id');
        $builder = new FormBuilder();
        $builder = $builder
            ->setMetaTitle('新增') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('device_id', 'hidden', '', '')
            ->addFormItem('number', 'num', '生成个数', '生成个数')
            ->addFormItem('start_time', 'date', '起始日期', '起始日期')
            ->addFormItem('end_time', 'date', '截止日期', '截止日期')
            ->setFormData($data)
            ->display();
    }

    // 设备管理
    public function device_list() {

        if(IS_POST){
            $post = I('post.');
            if(!$post['ids']){
                $res['status'] = false;
                $res['msg'] = '勾选后操作';
                $this->std_return($res);
            }
            foreach($post['ids'] as $v){
                $ddd = [];
                $www['id'] = $v;
                $ddd['is_reboot'] = 1;
                M('think_device',null)->where($www)->save($ddd);
            }
            $res['status'] = true;
            $res['msg'] = '成功';
            $this->std_return($res);
        }

        $getRes = API('Coffee')->get_device_list();
        $builder = new ListBuilder();
        $builder->setMetaTitle('设备管理');  // 设置页面标题
        if(MODULE_MARK != 'HOME_Admin'){
            $builder->addTopButton('addnew', array('href' => U('device_detail'))); // 添加新增按钮
        }
        $builder
            ->addTopButton('resume', array('href' => U('model2status',['model'=>'think_device','type'=>1]))) // 添加启用按钮
            ->addTopButton('forbid', array('href' => U('model2status',['model'=>'think_device','type'=>0]))) // 添加禁用按钮
            ->addTopButton('self', ['title'=>'重启','href'=>U(''),'target-form'=>'ids','class'=>'btn btn-primary-outline btn-pill ajax-post']);  
            if(MODULE_MARK != 'HOME_Admin'){
                $builder->addTopButton('self', ['title'=>'批量兑换码','href'=>'push_free_code','target-form'=>'ids','class'=>'btn btn-primary-outline btn-pill ajax-post']);  
            }
            if(MODULE_MARK != 'HOME_Admin'){
                $builder->addTopButton('self', ['title'=>'分配','href'=>'push_device2user','target-form'=>'ids','class'=>'btn btn-primary-outline btn-pill ajax-post']);  
            }
        $builder->setSearch('请输入ID/标题', U(''))
            ->addTableColumn('number', '设备编号')
            // ->addTableColumn('province_name', '省份')
            ->addTableColumn('city_name', '市区')
            ->addTableColumn('shop_name', '场所')
            ->addTableColumn('device_place', '地点')
            ->addTableColumn('uid_name', '管理员')
            // ->addTableColumn('location', '地址')
            // ->addTableColumn('remain_sim_traffic', 'sim卡流量', 'short', ['length'=>4])
            // ->addTableColumn('sim_phone', 'sim卡电话号')
            // ->addTableColumn('remain_sim_money', 'sim卡余额', 'short', ['length'=>4])
            // ->addTableColumn('created_at', '添加时间')
            ->addTableColumn('tune1_water_cup_count', '水总杯')
            ->addTableColumn('tune1_remain_water_cup_count', '水余杯')
            ->addTableColumn('cup_count', '总杯')
            ->addTableColumn('tune1_water_per_cup', '余杯')
            ->addTableColumn('is_reboot', '重启', 'status')
            ->addTableColumn('status', '状态', 'status')
            ->addTableColumn('is_online', '在线', 'status')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($getRes['data'])     // 数据列表
            ->setTableDataPage($getRes['page']->show());  // 数据列表分页
            if(MODULE_MARK != 'HOME_Admin'){
                $builder
                ->addRightButton('self',['name'=>'3','title'=>'广告','href'=>url('advertise_list_device',['id'=>'__data_id__'])])
                ->addRightButton('self',['name'=>'5','title'=>'兑换码','href'=>url('free_code_list',['id'=>'__data_id__'])])
                ->addRightButton('self',['name'=>'6','title'=>'分享','href'=>url('weixin_share',['device_id'=>'__data_id__'])]);
            }
            $builder
            ->addRightButton('self',['name'=>'2','title'=>'通道','href'=>url('device_tune_list',['id'=>'__data_id__'])])
            ->addRightButton('edit',['href'=>url('device_detail',['id'=>'__data_id__'])])           // 添加编辑按钮
            ->addRightButton('self',['name'=>'4','title'=>'二维码','href'=>url('make_qrcode',['id'=>'__data_id__'])])
            ->display();
    }

    // 分享
    public function weixin_share() {
        if (request()->isPost()) {
            $getRes = API('Coffee')->edit_device_weixin_share(I('post.'));
            $this->std_return($getRes);
        }
        // 模板
        $list = M('cf_device_weixin_template',null)->select();
        foreach($list as $v){
            $list_kv[$v['id']] =$v['title'];
        }
        $www['device_id'] = I('device_id');
        $data = D2('CfDeviceWeixin')->where($www)->find();
        $data['device_id'] = I('device_id');
        $builder = new FormBuilder();
        $builder = $builder
            ->setMetaTitle('分享') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('id', 'hidden', '', '')
            ->addFormItem('device_id', 'hidden', '', '')
            ->addFormItem('tpl_id', 'select', '模板', '模板',$list_kv)
            // ->addFormItem('title', 'text', '标题', '标题')
            // ->addFormItem('desc', 'text', '说明', '说明')
            // ->addFormItem('link', 'text', '跳转地址', '跳转地址')
            // ->addFormItem('img_url', 'picture', '图片', '图片')
            ->setFormData($data)
            ->display();
    }            


    // 设备详情
    public function device_detail() {
        if (request()->isPost()) {
            $getRes = API('Coffee')->edit_device(I('post.'));
            $this->std_return($getRes);
        }
        $getRes['data']['device_id'] = I('device_id');
        if(I('id')){
            $www['a.id'] = I('id');
            $getRes = API('Coffee')->get_device_list($www);
            $data = $getRes['data'][0];
        }else{
            $data['number']     = (int)((int)date("Ydis",time())+mt_rand(1,41111100)+mt_rand(1,500)+mt_rand(1,1100)-mt_rand(1,1100)-mt_rand(1,150));
        }
        $builder = new FormBuilder();
        $builder = $builder
            ->setMetaTitle('新增') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('id', 'hidden', '', '')
            ->addFormItem('number', 'hidden', '', '')
            ->addFormItem('shop_id', 'select', '场所', '场所', API('Coffee')->get_shop_list()['data'] );
        if(MODULE_MARK != 'HOME_Admin'){
            $builder->addFormItem('is_half_price', 'radio', '允许半价','允许半价', [1=>'允许',0=>'不可以'])
            ->addFormItem('is_add_bean', 'radio', '允许集酷豆','允许集酷豆', [1=>'允许',0=>'不可以']);
        }
        $builder
            ->addFormItem('device_place', 'text', '设备地点', '设备地点')
            ->addFormItem('tune1_water_cup_count', 'num', '水可用总杯数', '水可用总杯数')
            ->addFormItem('tune1_remain_water_cup_count', 'num', '水剩余杯数', '水剩余杯数')
            ->addFormItem('cup_count', 'num', '杯可用总数', '杯可用总数')
            ->addFormItem('remain_cup_count', 'num', '杯剩余数', '杯剩余数')
            ->addFormItem('sim_phone', 'num', 'sim卡电话号', 'sim卡电话号')
            ->addFormItem('remain_sim_traffic', 'textarea', 'sim卡剩余流量')
            ->addFormItem('remain_sim_money', 'textarea', 'sim卡剩余钱数')
            ->setFormData($data)
            ->display();
    }

    // 通道列表
    public function device_tune_list() {
        $getRes = API('Coffee')->get_device_tune(I('id'));
        $builder = new ListBuilder();
        $builder->setMetaTitle('设备通道详情')  // 设置页面标题
            ->addTopButton('addnew', array('href' => U('tune_detail',['device_id'=>I('id')]))) // 添加新增按钮
            ->addTopButton('resume', array('href' => U('model2status',['model'=>'cf_device_tune','type'=>1]))) // 添加启用按钮
            ->addTopButton('forbid', array('href' => U('model2status',['model'=>'cf_device_tune','type'=>0]))); // 添加禁用按钮
        $builder
            ->addTableColumn('number', '设备编号')
            ->addTableColumn('shop_name', '场所')
            ->addTableColumn('goods_type', '设备通道')
            ->addTableColumn('title', '饮品')
            ->addTableColumn('price', '价格')
            ->addTableColumn('water_per_cup', '每杯用水')
            ->addTableColumn('material_per_cup', '每杯用料')
            ->addTableColumn('material_cup_count', '料可用总杯数')
            ->addTableColumn('remain_material_cup_count', '料剩余杯数')
            ->addTableColumn('status', '状态', 'status')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($getRes['data'])     // 数据列表
            ->addRightButton('edit',['href'=>url('tune_detail',['id'=>'__data_id__'])])           // 添加编辑按钮
            ->display();
    }

    // 通道详情
    public function tune_detail() {
        if (request()->isPost()) {
            $getRes = API('Coffee')->edit_tune(I('post.'));
            $this->std_return($getRes);
        }
        $getRes['data']['device_id'] = I('device_id');
        if(I('id')){
            $www['id'] = I('id');
            $getRes = API('Coffee')->get_tune_detail($www);
        }
        $builder = new FormBuilder();
        $builder = $builder
            ->setMetaTitle('新增') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('id', 'hidden', '', '')
            ->addFormItem('device_id', 'hidden', '', '')
            ->addFormItem('title', 'text', '名称', '名称')
            ->addFormItem('title_en', 'text', '英文名称', '英文名称')
            ->addFormItem('img', 'picture', '图片', '图标LOGO')
            ->addFormItem('price', 'price', '价格', '价格')
            ->addFormItem('goods_type', 'select', '通道号', '通道号(对应咖啡机通道1-5）',[1=>1,2=>2,3=>3,4=>4,5=>5])
            ->addFormItem('water_per_cup', 'num', '每杯用水', '每杯用水')
            ->addFormItem('material_per_cup', 'num', '每杯用料', '每杯用料')
            ->addFormItem('material_cup_count', 'num', '料可用总杯数', '料可用总杯数')
            ->addFormItem('remain_material_cup_count', 'num', '料剩余杯数', '料剩余杯数')
            ->setFormData($getRes['data'])
            ->display();
    }

    // 故障列表
    public function device_trouble_list() {
        if (I('dotype') == 'del') {
            $getRes = API('Coffee')->del_device_trouble(I('id'));
            $this->std_return($getRes);
        }
        $getRes = API('Coffee')->get_device_trouble_list();
        $builder = new ListBuilder();
        $builder->setMetaTitle('故障列表');  // 设置页面标题
        $builder
            ->addTableColumn('number', '设备编号')
            ->addTableColumn('troublecup_name', '缺杯故障', 'status')
            ->addTableColumn('troublewater_name', '缺水故障', 'status')
            ->addTableColumn('troublepump_name', '抽水功能故障', 'status')
            ->addTableColumn('troubletemp_name', '文档传感器故障', 'status')
            ->addTableColumn('created_at', '发布时间')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($getRes['data'])     // 数据列表
            ->addRightButton('delete',['href'=>url('',['dotype'=>'del','id'=>'__data_id__'])])           // 添加编辑按钮
            ->display();
    }

    // 设备广告列表
    public function advertise_list_dev() {
        $www['advertise_class_id'] = '21';
        $this->advertise_list($www);
    }

    public function advertise_list_wx() {
        $www['advertise_class_id'] = '20';
        $this->advertise_list($www);
    }

    public function advertise_list($www) {
        if (I('dotype') == 'del') {
            $getRes = API('Coffee')->del_advertise(I('id'));
            $this->std_return($getRes);
        }
        $_pre = '_dev';
        if($www['advertise_class_id'] == '20'){
            $_pre = '_wx';
        }
        $getRes = API('Coffee')->get_advertise_list($www);
        $builder = new ListBuilder();
        $builder->setMetaTitle('设备广告列表')  // 设置页面标题
            ->addTopButton('addnew', array('href' => U('advertise_detail'.$_pre,['device_id'=>I('id')]))) // 添加新增按钮
            ->addTopButton('resume', array('href' => U('model2status',['model'=>'think_advertise','type'=>1]))) // 添加启用按钮
            ->addTopButton('forbid', array('href' => U('model2status',['model'=>'think_advertise','type'=>0]))); // 添加禁用按钮
        
        $builder->setSearch('请输入ID/标题', U(''))
            ->addTableColumn('id', 'ID')
            ->addTableColumn('show_name', '名称')
            ->addTableColumn('type_name', '类型')
            ->addTableColumn('file_img_name', '图片预览','avatar')
            ->addTableColumn('background_name', '背景图片','avatar')
            ->addTableColumn('file_media', '视频预览','media')
            ->addTableColumn('advertise_class_name', '类别')
            ->addTableColumn('star_time', '开始时间')
            ->addTableColumn('end_time', '结束时间')
            ->addTableColumn('status', '状态', 'status')
            // ->addTableColumn('created_at', '添加时间')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($getRes['data'])     // 数据列表
            ->setTableDataPage($getRes['page']->show())  // 数据列表分页
            ->addRightButton('edit',['href'=>url('advertise_detail'.$_pre,['id'=>'__data_id__'])])           // 添加编辑按钮
            ->addRightButton('delete',['href'=>url('',['dotype'=>'del','id'=>'__data_id__'])])           // 添加编辑按钮
            ->display();
    }

    // 设备广告编辑
    public function advertise_detail_dev() {
        $www['advertise_class_id'] = '21';
        $this->advertise_detail($www);
    }

    public function advertise_detail_wx() {
        $www['advertise_class_id'] = '20';
        $this->advertise_detail($www);
    }

    public function advertise_detail($www) {
        if (request()->isPost()) {
            $getRes = API('Coffee')->edit_advertise(I('post.'));
            $this->std_return($getRes);
        }
        $data['advertise_class_id'] = $www['advertise_class_id'];
        if(I('id')){
            $www['id'] = I('id');
            $data = API('Coffee')->get_advertise($www);
        }
        $builder = new FormBuilder();
        $builder = $builder
            ->setMetaTitle('新增') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('id', 'hidden', '', '')
            ->addFormItem('advertise_class_id', 'hidden', '', '')
            ->addFormItem('show_name', 'text', '名称', '名称标识')
            ->addFormItem('type', 'radio', '类型', '类型', [1=>'图片',2=>'视频'])
            // ->addFormItem('advertise_class_id', 'radio', '类别', '类别', [20=>'微信广告',21=>'设备广告'])
            ->addFormItem('file_img', 'picture', '广告图片', '广告图片')
            ->addFormItem('background', 'picture', '背景图片', '背景图片')
            ->addFormItem('file_media', 'media', '视频', '视频')
            ->addFormItem('star_time', 'date', '起始日期', '起始日期')
            ->addFormItem('end_time', 'date', '截止日期', '截止日期')
            ->setFormData($data)
            ->display();
    }

    public function old_os() {
        $this->redirect('http://pay.zhuhemedia.com');
    }

    // 广告管理
    public function advertise_list_device() {
        if (I('dotype') == 'del') {
            $www['id'] = I('id');
            M('think_advertise_device',null)->where($www)->delete();
            $res['status'] = true;
            $res['msg'] = '成功';
            $this->std_return($res);
        }
        $www['device_id'] = I('id');
        $getRes = API('Coffee')->advertise_list_device($www,'_device');
        $builder = new ListBuilder();
        $builder->setMetaTitle('设备广告管理')  // 设置页面标题
            ->addTopButton('addnew', array('href' => U('advertise_edit_device',['device_id'=>I('id')]))); // 添加新增按钮
        $builder
            ->addTableColumn('advertise_id', '广告ID')
            ->addTableColumn('show_name', '名称')
            ->addTableColumn('type_name', '类型')
            ->addTableColumn('file_img', '图片预览','avatar')
            ->addTableColumn('background', '背景图片','avatar')
            ->addTableColumn('file_media', '视频预览','media')
            ->addTableColumn('advertise_class_name', '类别')
            ->addTableColumn('star_time', '开始时间')
            ->addTableColumn('end_time', '结束时间')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($getRes['data'])     // 数据列表
            ->addRightButton('edit',['href'=>url('advertise_edit_device',['id'=>'__data_id__'])])           // 添加编辑按钮
            ->addRightButton('delete',['href'=>url('',['dotype'=>'del','id'=>'__data_id__'])])           // 添加编辑按钮
            ->display();
    }

    // 新增设备广告
    public function advertise_edit_device() {
        if (request()->isPost()) {
            $getRes = API('Coffee')->advertise_edit_device(I('post.'),'_device');
            $this->std_return($getRes);
        }
        $data['device_id'] = I('device_id');
        if(I('id')){
            $www['id'] = I('id');
            $getRes = API('Coffee')->advertise_list_device($www,'_device');
            $data = $getRes['data'][0];  
        }
        $w2ww['advertise_class_id'] = '21';
        $ads = M('think_advertise',null)->where($w2ww)->select();
        foreach($ads as $v){
            $ads_kv[$v['id']] = $v['show_name'];
        }
        $builder = new FormBuilder();
        $builder = $builder
            ->setMetaTitle('新增') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('id', 'hidden', '', '')
            ->addFormItem('device_id', 'hidden', '', '')
            ->addFormItem('advertise_id', 'select', '名称', '名称标识', $ads_kv)
            ->setFormData($data)
            ->display();
    }

    // 场所管理
    public function shop_list() {
        $getRes = API('Coffee')->shop_list();
        $builder = new ListBuilder();
        $builder->setMetaTitle('场所管理');  // 设置页面标题
        $builder
            ->addTableColumn('id', '商场ID')
            ->addTableColumn('province_name', '省份')
            ->addTableColumn('city_name', '市区')
            ->addTableColumn('shop_number', '场所编号')
            ->addTableColumn('location', '场所位置')
            ->addTableColumn('type_name', '场所类型')
            ->addTableColumn('created_at', '创建时间')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($getRes['data'])     // 数据列表
            ->addRightButton('self',['name'=>'3','title'=>'广告管理','href'=>url('advertise_list_shop',['id'=>'__data_id__'])])
            ->display();
    }

    // 微信广告管理
    public function advertise_list_shop() {
        if (I('dotype') == 'del') {
            $www['id'] = I('id');
            M('think_advertise_weixin',null)->where($www)->delete();
            $res['status'] = true;
            $res['msg'] = '成功';
            $this->std_return($res);
        }
        $www['shop_id'] = I('id');
        $getRes = API('Coffee')->advertise_list_shop($www);
        $builder = new ListBuilder();
        $builder->setMetaTitle('设备广告管理')  // 设置页面标题
            ->addTopButton('addnew', array('href' => U('advertise_edit_shop',['shop_id'=>I('id')]))); // 添加新增按钮
        $builder
            ->addTableColumn('advertise_id', '广告ID')
            ->addTableColumn('show_name', '名称')
            ->addTableColumn('type_name', '类型')
            ->addTableColumn('file_img', '图片预览','avatar')
            ->addTableColumn('background', '背景图片','avatar')
            ->addTableColumn('file_media', '视频预览','media')
            ->addTableColumn('advertise_class_name', '类别')
            ->addTableColumn('star_time', '开始时间')
            ->addTableColumn('end_time', '结束时间')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($getRes['data'])     // 数据列表
            ->addRightButton('edit',['href'=>url('advertise_edit_shop',['id'=>'__data_id__'])])           // 添加编辑按钮
            ->addRightButton('delete',['href'=>url('',['dotype'=>'del','id'=>'__data_id__'])])           // 添加编辑按钮
            ->display();
    }

    // 新增微信广告
    public function advertise_edit_shop() {
        if (request()->isPost()) {
            $getRes = API('Coffee')->advertise_edit_device(I('post.'),'_shop');
            $this->std_return($getRes);
        }
        $data['shop_id'] = I('shop_id');
        if(I('id')){
            $www['id'] = I('id');
            $getRes = API('Coffee')->advertise_list_device($www,'_shop');
            $data = $getRes['data'][0];  
        }
        $w2ww['advertise_class_id'] = '20';
        $w2ww['status'] = 1;
        $ads = M('think_advertise',null)->where($w2ww)->select();
        foreach($ads as $v){
            $ads_kv[$v['id']] = $v['show_name'];
        }
        $builder = new FormBuilder();
        $builder = $builder
            ->setMetaTitle('新增') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('id', 'hidden', '', '')
            ->addFormItem('shop_id', 'hidden', '', '')
            ->addFormItem('advertise_id', 'select', '名称', '名称标识', $ads_kv)
            ->setFormData($data)
            ->display();
    }

    // 二维码
    public function make_qrcode() {
        $www['id'] = I('id');
        $device = M('think_device',null)->where($www)->find();
        if($device['number']){
            $url = 'http://'.$_SERVER['HTTP_HOST'].'/home/index/index/device_number/'.$device['number'];
            $png_url = 'uploads/qrcode/'.$device['number'].'.jpg';
            // $png_url = $device['number'].'.jpg';
            API('Coffee')->make_qrcode($url,$png_url);
            $this->assign('png_url','/'.$png_url);
            $this->display();
        }
    }

    // 客户列表
    public function customer_list() {
        $getRes = API('Coffee')->get_device_list();
        foreach($getRes['data'] as $v){
            $device_list_kv[$v['id']] = $v['shop_name'].'/'.$v['number'];
        }
        $this->assign('device_list_kv',$device_list_kv);
        if(I('device_id'))
            $www['device_id'] = I('device_id');
        if(I('device_ids'))
            $www['device_id'] = array('in',I('device_ids'));
        $str = '';    
        if(I('start_time'))
            $str = 'create_time >= '.strtotime(I('start_time'));
        if(I('end_time'))
            if($str)
            $str .= ' and create_time <= '.(strtotime(I('end_time'))+60*60*24);
            else
            $str = ' create_time <= '.(strtotime(I('end_time'))+60*60*24);
        if($str)
        $www['_string'] = $str;
        $getRes = API('Coffee')->customer_list($www);
        // 使用Builder快速建立列表页面。
        $builder = new \nfutil\builder\ListBuilder();
        // 设置搜索页
        $listbuilder = APP_PATH . strtolower(request()->module()) . '/view/admin/index/customer_list.html';
        $template = APP_PATH . strtolower(request()->module()) . '/view/admin/builder/customer_list.html';
        $builder->setMetaTitle('模型列表')  // 设置页面标题
            ->addTopButton('self', ['title'=>'配送优惠券','href'=>'push_coupon','target-form'=>'ids','class'=>'btn btn-success-outline btn-pill ajax-post'])  
            ->setSearch('请输入ID/模型标题', U(''))
            ->addTableColumn('device_number', '设备号')
            // ->addTableColumn('open_id', 'open_id', 'short', ['length'=>4])
            ->addTableColumn('nickname', '昵称')
            // ->addTableColumn('sex', '性别')
            ->addTableColumn('headimgurl', '头像','avatar')
            // ->addTableColumn('subscribe_time', '订阅时间', 'time')
            // ->addTableColumn('subscribe', '是否订阅','status')
            ->addTableColumn('bean_num', '酷豆数')
            ->addTableColumn('is_half_price', '下杯半价','status')
            ->addTableColumn('coupon_num', '优惠券数')
            ->addTableColumn('create_time', '注册时间', 'time')
            ->setTableDataList($getRes['data'])     // 数据列表
            ->setTableDataPage($getRes['page'])  // 数据列表分页
            ->addTableColumn('right_button', '操作', 'btn')
            ->addRightButton('self',['cat'=>'1']) // 添加编辑按钮
            ->addRightButton('self',['name'=>'2','title'=>'查看优惠券','href'=>url('push_coupon',['ids_list'=>'__data_id__'])])
            ->setTemplate($template) // 有问题需要清缓存,名字不能是list
            ->display('',['_listbuilder_layout'=>$listbuilder]);
    }
    
    // 优惠券管理
    public function coupon_manage() {
        $getRes = API('Coffee')->coupon_list();
        $builder = new ListBuilder();
        $builder->setMetaTitle('优惠券管理')  // 设置页面标题
            ->addTopButton('addnew', array('href' => U('coupon_edit'))) // 添加新增按钮
            ->addTopButton('resume', array('href' => U('model2status',['model'=>'cf_coupon','type'=>1]))) // 添加启用按钮
            ->addTopButton('forbid', array('href' => U('model2status',['model'=>'cf_coupon','type'=>0]))); // 添加禁用按钮
        $builder
            ->addTableColumn('id', 'ID')
            ->addTableColumn('title', '名称')
            ->addTableColumn('rebate', '折扣比例')
            ->addTableColumn('start_time_name', '开始时间')
            ->addTableColumn('end_time_name', '结束时间')
            ->addTableColumn('device_ids_name', '可用设备')
            ->addTableColumn('status', '状态', 'status')
            // ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($getRes['data'])     // 数据列表
            // ->addRightButton('edit',['href'=>url('coupon_edit',['id'=>'__data_id__'])])           // 添加编辑按钮
            ->display();
    }

    // 优惠券编辑
    public function coupon_edit() {
        if (request()->isPost()) {
            $getRes = API('Coffee')->coupon_edit(I('post.'));
            $this->std_return($getRes);
        }
        if(I('id')){
            $www['id'] = I('id');
            $data = M('cf_coupon',null)->where($www)->find();
        }

        $device_list = M('think_device',null)->select();
        foreach($device_list as $v){
            $content = \unserialize($v['content']);
            $device_list_kv[$v['id']] = $content['device_place'].'/'.$v['number'];
        }

        $builder = new FormBuilder();
        $builder = $builder
            ->setMetaTitle('新增') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('id', 'hidden', '', '')
            ->addFormItem('title', 'text', '名称', '名称标识')
            ->addFormItem('rebate', 'select', '折扣比例', '折扣比例', [9=>'9折',8=>'8折',7=>'7折',6=>'6折',5=>'5折',4=>'4折',3=>'3折',2=>'2折',1=>'1折',0=>'0折'])
            ->addFormItem('device_ids', 'checkbox', '可用设备', '可用设备', $device_list_kv)
            ->addFormItem('start_time', 'date', '起始日期', '起始日期')
            ->addFormItem('end_time', 'date', '截止日期', '截止日期')
            ->setFormData($data)
            ->display();
    }

    // 配送兑换码
    public function push_free_code() {
        if(I('ids_list')){
            $ids_list = explode(',',I('ids_list')) ;
            if(IS_POST){
                if (request()->isPost()) {
                    foreach($ids_list as $v){
                        $post = [];
                        $post['device_id'] = $v;
                        $post['number'] = I('number');
                        $post['start_time'] = I('start_time');
                        $post['end_time'] = I('end_time');
                        $post['img'] = I('img');
                        $getRes = API('Coffee')->make_free_code($post);
                    }
                    $this->std_return($getRes);
                }
            }
            $this->assign('ids_count',count($ids_list));
            // 获得微信广告图片
            $ww6w['status'] = 1;
            $data_list = M('think_advertise',null)->where($ww6w)->order('id desc')->select();
            foreach($data_list as $v){
                $ads_kv[$v['file_name']] = $v['show_name'];
            }
            $this->assign('ads_kv',$ads_kv);
            $this->display();
        }else{
            $res['status'] = false;
            $res['msg'] = '勾选后操作';
            if($_POST['ids']){
                $ids = \implode(',',$_POST['ids']) ;
                $res['status'] = true;
                $res['msg'] = '';
            }
            $res['url'] = U('push_free_code',['ids_list'=>$ids]);
            $this->std_return($res);
        }
    }

    // 配送优惠券
    public function push_coupon() {
        if(I('ids_list')){
            if(IS_POST){
                // 获得优惠券信息
                $www['id'] = I('coupon_id');
                $coupon = M('cf_coupon',null)->where($www)->find();
                $post['coupon_id'] = I('coupon_id');
                $post['start_time'] = $coupon['start_time'];
                $post['end_time'] = $coupon['end_time'];
                $post['rebate'] = $coupon['rebate'];
                $post['status'] = 1;
                $post['coupon_content'] = serialize($coupon);
                $ids_list = explode(',',I('ids_list')) ;
                $customer_list = M('cf_customer',null)->select();
                foreach($customer_list as $v){
                    $customer_list_kv[$v['id']] = $v['open_id'];
                }
                foreach($ids_list as $v){
                    $post['customer_id'] = $v;
                    // 获得open_id
                    $post['open_id'] = $customer_list_kv[$v['id']];
                    M('cf_customer_coupon',null)->add($post);
                }
                $res['status'] = true;
                $res['msg'] = '完成';
                $res['url'] = U('customer_list');
                $this->std_return($res);
            }
            $ids_list = explode(',',I('ids_list')) ;
            $this->assign('ids_count',count($ids_list));
            // 获得可用优惠券
            $where['status'] = 1;
            $where['end_time'] = array('egt',time());
            $getRes = API('Coffee')->coupon_list($where);
            foreach($getRes['data'] as $v){
                $coupon_list_kv[$v['id']] = $v['title'].'/'.$v['rebate'].'折';
            }
            $this->assign('coupon_list_kv',$coupon_list_kv);
            if(count($ids_list) == 1){
                // 客户信息
                $ww2w['id'] = $ids_list[0];
                $getRes = API('Coffee')->customer_list($ww2w);
                $this->assign('customer',$getRes['data'][0]);
            }
            $this->display();
        }else{
            $res['status'] = false;
            $res['msg'] = '勾选后操作';
            if($_POST['ids']){
                $ids = \implode(',',$_POST['ids']) ;
                $res['status'] = true;
                $res['msg'] = '';
            }
            $res['url'] = U('push_coupon',['ids_list'=>$ids]);
            $this->std_return($res);
        }
    }

    // 消费记录
    public function pay_log() {
        $getRes = API('Coffee')->order_list(['is_pay'=>1]);
        $builder = new ListBuilder();
        $builder->setMetaTitle('消费记录');  // 设置页面标题
        $builder
            ->addTableColumn('order_id', '订单编号')
            ->addTableColumn('nickname', '用户名')
            ->addTableColumn('title', '商品名')
            ->addTableColumn('device_id', '设备id')
            ->addTableColumn('price', '金额')
            // ->addTableColumn('customer_coupon_id', '优惠券ID', 'status')
            ->addTableColumn('coupon_name', '优惠券', 'status')
            ->addTableColumn('bean_num', '酷豆', 'status')
            ->addTableColumn('free_code', '兑换码', 'status')
            ->addTableColumn('is_half', '半价', 'status')
            ->addTableColumn('create_time', '时间')
            ->setTableDataList($getRes['data'])     // 数据列表
            ->setTableDataPage($getRes['page']->show())  // 数据列表分页
            ->display();
    }

    public function data_list() {

        // 归属设备
        $ww2w = API('Coffee')->get_admin_device_map([],'id');
        $device_list = M('think_device',null)->where($ww2w)->select();
        $device_list_kv[-1] = '全部';
        foreach($device_list as $v){
            $content = \unserialize($v['content']);
            $device_list_kv[$v['id']] = $content['device_place'].'/'.$v['number'];
        }
        $this->assign('device_list_kv', $device_list_kv);
        // 通道
        $device_tune_list = M('cf_device_tune',null)->select();
        $device_tune_list_kv[-1] = [['id'=>-1,'title'=>1],['id'=>-2,'title'=>2],['id'=>-3,'title'=>3],['id'=>-4,'title'=>4],['id'=>-5,'title'=>5]];
        foreach($device_tune_list as $v){
            $device_tune_list_kv[$v['device_id']][] = $v;
        }
        $this->assign('device_tune_list_kv', $device_tune_list_kv);
        // 在线设备
        $ww2w['is_online'] = 1;
        $online_num = M('think_device',null)->where($ww2w)->count();
        $top_info['online_num'] = $online_num?:0;

        //筛选
        $www = API('Coffee')->get_admin_device_map([]);
        $today = time();
        if(I('start_time'))
            $today = strtotime(I('start_time'));
        $this->assign('start_time', date('Y-m-d',$today));
        if(I('device_select') == -1){
            if(I('tune_select') == -1)
                $www['goods_type'] = 1;
            if(I('tune_select') == -2)
                $www['goods_type'] = 2;
            if(I('tune_select') == -3)
                $www['goods_type'] = 3;
            if(I('tune_select') == -4)
                $www['goods_type'] = 4;
            if(I('tune_select') == -5)
                $www['goods_type'] = 5;
        }else{
            if(I('device_select'))
                $www['device_id'] = I('device_select');
            if(I('tune_select'))
                $www['tune_id'] = I('tune_select');
        }
        $www['is_pay'] = 1;
        $www['create_time'] = array('exp',' >= "'.date('Y-m-d',$today).' 00:00:00" and create_time <= "'.date('Y-m-d',$today).' 23:59:59" ');
        $order_list = M('cf_order',null)->where($www)->select();
        $user_num = M('cf_order',null)->where($www)->count();
        foreach($order_list as $v){
            $top_info['price'] += $v['price']?:0;
            $top_info['cut_price'] += $v['cut_price']?:0;
        }
        $top_info['price'] = $top_info['price']?:0;
        $top_info['cut_price'] = $top_info['cut_price']?:0;
        $top_info['cup_num'] = count($order_list)?:0;
        $top_info['user_num'] = $user_num?:0;
        $this->assign('top_info', $top_info);
        // 今日汇总
        $order_list = M('cf_order',null)->where($www)->select();
        foreach($order_list as $v){
            $order_list_kv[intval(date('H',strtotime($v['create_time'])))][] = $v;
            $total_cup_day += 1;
            $total_price_day += $v['price'];
        }
        $getRes = _set_data(24,$order_list_kv);
        $this->assign('day_order', $getRes['day_order']?:0);
        $this->assign('day_price', $getRes['day_price']?:0);
        $this->assign('day_cup_num', $getRes['day_cup_num']?:0);
        $this->assign('total_cup_day', $total_cup_day?:0);
        $this->assign('total_price_day', $total_price_day?:0);
        // 月
        $www['create_time'] = array('exp',' >= "'.date('Y-m-01', strtotime(date("Y-m-d",$today))).' 00:00:00" and create_time <= "'.date('Y-m-d', strtotime("$BeginDate +1 month -1 day",$today)).' 23:59:59" ');
        $order_list = M('cf_order',null)->where($www)->select();
        $order_list_kv = [];
        foreach($order_list as $v){
            $order_list_kv[intval(date('d',strtotime($v['create_time'])))/2][] = $v;
            $total_cup_month += 1;
            $total_price_month += $v['price'];
        }
        $getRes = _set_data(16, $order_list_kv);
        $this->assign('month_order', $getRes['day_order']?:0);
        $this->assign('month_price', $getRes['day_price']?:0);
        $this->assign('month_cup_num', $getRes['day_cup_num']?:0);
        $this->assign('total_cup_month', $total_cup_month?:0);
        $this->assign('total_price_month', $total_price_month?:0);
        // 年
        $www['create_time'] = array('exp',' >= "'.date('Y-01-01', strtotime(date("Y-m-d",$today))).' 00:00:00" and create_time <= "'.date('Y-12-31', strtotime(date("Y-m-d",$today))).' 23:59:59" ');
        $order_list = M('cf_order',null)->where($www)->select();
        $order_list_kv = [];
        foreach($order_list as $v){
            $order_list_kv[intval(date('m',strtotime($v['create_time'])))][] = $v;
            $total_cup_year += 1;
            $total_price_year += $v['price'];
        }
        $getRes = _set_data(12, $order_list_kv);
        $this->assign('year_order', $getRes['day_order']?:0);
        $this->assign('year_price', $getRes['day_price']?:0);
        $this->assign('year_cup_num', $getRes['day_cup_num']?:0);
        $this->assign('total_cup_year', $total_cup_year?:0);
        $this->assign('total_price_year', $total_price_year?:0);
        $this->display();
    }

    // 分配
    public function push_device2user() {
        if(I('ids_list')){
            $ids_list = explode(',',I('ids_list')) ;
            if(IS_POST){
                if (request()->isPost()) {
                    foreach($ids_list as $v){
                        $post = [];
                        $post['device_id'] = $v;
                        $post['uid'] = I('uid');
                        API('Coffee')->push_device2user($post);
                    }
                    $res['status'] = true;
                    $res['msg'] = '完成';
                    $res['url'] = U('device_list');
                    $this->std_return($res);
                }
            }
            $this->assign('ids_count',count($ids_list));
            // 获得管理
            // $data_list = API('Coffee')->get_access_users();
            $www['status'] = 1;
            $data_list = M('nf_admin_user',null)->where($www)->order('id desc')->select();
            foreach($data_list as $v){
                $user_kv[$v['id']] = $v['username'];
            }
            $this->assign('user_kv',$user_kv);
            $this->display();
        }else{
            $res['status'] = false;
            $res['msg'] = '勾选后操作';
            if($_POST['ids']){
                $ids = \implode(',',$_POST['ids']) ;
                $res['status'] = true;
                $res['msg'] = '';
            }
            $res['url'] = U('push_device2user',['ids_list'=>$ids]);
            $this->std_return($res);
        }
    }

    // 
    public function user_list(){
        $www['nickname'] = array('neq','超级管理员');
        $www['status'] = 1;
        $getRes = API('Coffee')->get_user_list($www);
        // 使用Builder快速建立列表页面
        $builder = new \nfutil\builder\ListBuilder();
        $builder->setMetaTitle('商户列表') // 设置页面标题
            ->addTableColumn('id', 'UID')
            ->addTableColumn('username', '用户名')
            ->addTableColumn('mobile', '手机号')
            // ->addTableColumn('mobile', '总营收')
            ->addTableColumn('pay_money', '余额')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($getRes['data'])     // 数据列表
            ->setTableDataPage($getRes['page']->show());  // 数据列表分页
        $builder
            // ->addRightButton('self',['name'=>'1','title'=>'银行卡信息','href'=>url('user_card',['uid'=>'__data_id__'])])
            ->addRightButton('self',['name'=>'2','title'=>'账目列表','href'=>url('user_money_record',['uid'=>'__data_id__'])])
            ->addRightButton('self',['name'=>'3','title'=>'打款','href'=>url('user_pay',['uid'=>'__data_id__'])])
            ->addRightButton('self',['name'=>'4','title'=>'设置','href'=>url('user_pay_set',['uid'=>'__data_id__'])])
            ->display();
    }

    public function user_card($uid=''){
        if (request()->isPost()) {
            $post = I('post.');
            $getRes['status'] = true;
            $getRes['msg'] = '成功';
            if($post['id']){
                $www['id'] = $post['id'];
                M('cf_user_info',null)->where($www)->save($post);
            }else{
                M('cf_user_info',null)->add($post);
            }
            $this->std_return($getRes);
        }
        $user['uid'] = I('uid')?:$uid;
        $www['uid'] = I('uid')?:$uid;
        $user_tmp = M('cf_user_info',null)->where($www)->find();
        if($user_tmp)
            $user = $user_tmp;
        $builder = new FormBuilder();
        $builder = $builder
            ->setMetaTitle('新增') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('id', 'hidden', '', '')
            ->addFormItem('uid', 'hidden', '', '')
            ->addFormItem('true_name', 'text', '姓名', '姓名')
            ->addFormItem('card_num', 'text', '卡号', '卡号')
            ->addFormItem('card_bank', 'select', '开户行', '开户行', API('Coffee')->bank)
            ->setFormData($user)
            ->display();
    }

    public function user_money_record($uid=''){
        $www['uid'] = $uid?:I('uid');
        $user_info = M('cf_user_info',null)->where($www)->find();
        $www['status'] = 1;
        $getRes = API('Coffee')->get_user_money_list($www);
        $listbuilder = APP_PATH . strtolower(request()->module()) . '/view/admin/index/user_money_record.html';
        $template = APP_PATH . strtolower(request()->module()) . '/view/admin/builder/user_money_record.html';
        // 使用Builder快速建立列表页面
        $builder = new \nfutil\builder\ListBuilder();
        $builder->setMetaTitle('商户列表'); // 设置页面标题
        if(MODULE_MARK != 'HOME_Admin'){
            $builder->addTopButton('addnew', array('href' => U('user_money_record_edit',['uid'=>I('uid')]))); // 添加新增按钮
        }else{
            // $builder->addTopButton('self', ['title'=>'打款账户','href'=>'user_card','class'=>'btn btn-success-outline btn-pill']) 
            // ->addTopButton('self', ['title'=>'提现（总金额：'.$user_info['pay_money'].'）','href'=>'push_coupon','target-form'=>'ids','class'=>'btn btn-success-outline btn-pill ajax-post']);  
            $builder->addTopButton('self', ['title'=>'提现（总金额：'.$user_info['pay_money'].'）','href'=>'cash_out','class'=>'btn btn-primary-outline btn-pill']);  
        }
        $builder->addTableColumn('id', 'id')
            ->addTableColumn('remark', '备注')
            ->addTableColumn('order_number', '订单号')
            ->addTableColumn('payment_no', '打款编号')
            ->addTableColumn('pay_money', '金额')
            ->addTableColumn('opt', '增减')
            ->addTableColumn('status_admin', '打款状态','status')
            ->addTableColumn('date_time', '日期');
            if(MODULE_MARK != 'HOME_Admin'){
                $builder->addTableColumn('right_button', '操作', 'btn');
            }
        $builder->setTableDataList($getRes['data'])     // 数据列表
            ->setTableDataPage($getRes['page']->show());  // 数据列表分页
        if(MODULE_MARK != 'HOME_Admin'){
        $builder
            ->addRightButton('delete',['href'=>U('model2status',['model'=>'cf_user_money_record','type'=>0,'id'=>'__data_id__'])]);           // 添加编辑按钮
        }
        $builder
            ->setTemplate($template) // 有问题需要清缓存,名字不能是list
            ->display('',['_listbuilder_layout'=>$listbuilder]);
    }

    public function user_money_record_edit(){
        if (request()->isPost()) {
            $getRes = API('Coffee')->user_money_record_edit(I('post.'));
            $this->std_return($getRes);
        }
        $record['uid'] = I('uid');
        $builder = new FormBuilder();
        $builder = $builder
            ->setMetaTitle('编辑') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('uid', 'hidden', '', '')
            ->addFormItem('opt', 'select', '增减', '增减',['+'=>'+','-'=>'-'])
            ->addFormItem('pay_money', 'text', '金额', '金额')
            ->addFormItem('remark', 'text', '备注', '备注')
            ->setFormData($record)
            ->display();
    }

    public function user_pay(){
        if (request()->isPost()) {
            $getRes = API('Coffee')->user_pay(I('post.'));
            $this->std_return($getRes);
        }
        $www['w.uid'] = I('uid');
        $data = M('nf_admin_user',null)->alias('a')->field('w.id as s_id,w.*,a.*')
            ->join('cf_user_info w ON a.id = w.uid','LEFT')->where($www)->find();
        if(!$data['card_num']){
            $res['status'] = false;
            $res['msg'] = '请添加银行卡信息';
            $this->std_return($res);
        }
        $data['remark'] = '结算打款';
        $builder = new FormBuilder();
        $builder = $builder
            ->setMetaTitle('打款') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('uid', 'hidden', '', '')
            ->addFormItem('true_name', 'text', '姓名', '姓名')
            ->addFormItem('card_bank', 'select', '开户行', '开户行', API('Coffee')->bank)
            ->addFormItem('card_num', 'text', '卡号', '卡号')
            ->addFormItem('pay_money', 'text', '金额', '金额')
            ->addFormItem('code', 'text', '口令', '输入口令：打款')
            ->addFormItem('remark', 'text', '备注', '备注')
            ->setFormData($data)
            ->display();
    }

    public function user_pay_set(){
        if (request()->isPost()) {
            $post = I('post.');
            $getRes['status'] = true;
            $getRes['msg'] = '成功';
            // 微信
            $ww2w['open_id'] = $post['open_id'];
            $wx = M('cf_customer',null)->where($ww2w)->find();
            $post['wx_fields'] = serialize($wx);
            if($post['id']){
                $www['id'] = $post['id'];
                M('cf_user_info',null)->where($www)->save($post);
            }else{
                M('cf_user_info',null)->add($post);
            }
            $this->std_return($getRes);
        }
        $user['uid'] = I('uid')?:$uid;
        $www['uid'] = I('uid')?:$uid;
        $user_tmp = M('cf_user_info',null)->where($www)->find();
        if($user_tmp)
            $user = $user_tmp;
        $customer_list = M('cf_customer',null)->select();
        foreach($customer_list as $v){
            $customer_list_kv[$v['open_id']] = $v['nickname'].'/'.$v['open_id'];
        }
        $builder = new FormBuilder();
        $builder = $builder
            ->setMetaTitle('打款') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('id', 'hidden', '', '')
            ->addFormItem('uid', 'hidden', '', '')
            ->addFormItem('deposit', 'text', '保障金', '保障金')
            ->addFormItem('rental', 'text', '设备租金', '设备租金')
            ->addFormItem('fee', 'text', '手续费比例', '手续费比例')
            ->addFormItem('rate_pay', 'text', '提现频率', '提现频率')
            ->addFormItem('open_id', 'select', '微信', '微信',$customer_list_kv)
            ->setFormData($user)
            ->display();
    }



    // 分享模板
    public function share_template(){
        $getRes = API('Coffee')->get_share_template_list();
        // 使用Builder快速建立列表页面
        $builder = new \nfutil\builder\ListBuilder();
        $builder->setMetaTitle('分享模板') // 设置页面标题
            ->addTopButton('addnew', array('href' => U('share_template_edit'))) // 添加新增按钮
            ->addTableColumn('id', 'UID')
            ->addTableColumn('title', '标题')
            ->addTableColumn('desc', '说明')
            ->addTableColumn('link', '跳转')
            ->addTableColumn('img_url_name', '图片','avatar')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($getRes['data'])     // 数据列表
            ->setTableDataPage($getRes['page']->show());  // 数据列表分页
        $builder
            ->addRightButton('edit',['href'=>url('share_template_edit',['id'=>'__data_id__'])])           // 添加编辑按钮
            ->display();
    }

    // 
    public function share_template_edit(){
        if (request()->isPost()) {
            $getRes = API('Coffee')->share_template_edit(I('post.'));
            $this->std_return($getRes);
        }
        $www['id'] = I('id');
        $data = D2('CfDeviceWeixinTemplate')->where($www)->find();
        $builder = new FormBuilder();
        $builder = $builder
            ->setMetaTitle('分享') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('id', 'hidden', '', '')
            ->addFormItem('title', 'text', '标题', '标题')
            ->addFormItem('desc', 'text', '说明', '说明')
            ->addFormItem('link', 'text', '跳转地址', '跳转地址')
            ->addFormItem('img_url', 'picture', '图片', '图片')
            ->setFormData($data)
            ->display();
    }

    // 
    public function cash_out_manager(){
        if(I('id')){
            $www['id'] = I('id');
            $record = M('cf_user_money_record',null)->where($www)->find();
            if($record['status_admin']){
                $res['status'] = false;
                $res['msg'] = '已打款';
                $this->std_return($res);
            }
            // 支付
            if($record['pay_money'] && $record['pay_money'] > 0 ){
                $amount = $record['pay_money']*100;
                $getRes = API('Wechat')->pay_back($record['open_id'], $amount, '提现');
                if($getRes['result_code'] == 'SUCCESS'){
                    $ddd['pay_content'] = \serialize($getRes);
                    $ddd['payment_no'] = $getRes['payment_no'];
                    $ddd['status_admin'] = 1;
                    M('cf_user_money_record',null)->where($www)->save($ddd);
                    $res['status'] = true;
                    $res['msg'] = '成功';
                    $this->std_return($res);
                }
            }
            $res['status'] = false;
            $res['msg'] = '错误：'.$getRes['err_code_des']?:'异常';
            $this->std_return($res);
        }
        $www['status'] = 1;
        $www['opt_type'] = '提现';
        $getRes = API('Coffee')->get_user_money_list($www);
        // 使用Builder快速建立列表页面
        $builder = new \nfutil\builder\ListBuilder();
        $builder->setMetaTitle('提现管理'); // 设置页面标题
        $builder->addTableColumn('id', 'id')
            ->addTableColumn('remark', '备注')
            ->addTableColumn('payment_no', '打款编号')
            ->addTableColumn('pay_money', '金额')
            ->addTableColumn('status_admin', '已打款','status')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($getRes['data'])     // 数据列表
            ->setTableDataPage($getRes['page']->show())  // 数据列表分页
            ->addRightButton('self', ['title'=>'打款','href'=>url('',['id'=>'__data_id__']),'class'=>'label label-warning-outline label-pill ajax-get confirm']) // 添加编辑按钮
            ->display();
    }
    

    




}

function _set_data($num, $order_list_kv){
    for($i=1;$i<=$num;$i++){
        $day_order[$i] = $order_list_kv[$i];
        $price_t = 0;
        $cup_num_t = 0;
        foreach($order_list_kv[$i] as $v){
            if(!$v)
                continue;
            $price_t += $v['price'];
            $cup_num_t += 1;
        }
        $day_price[$i] = $price_t;
        $day_cup_num[$i] = $cup_num_t;
    }
    $data['day_order'] = $day_order;
    $data['day_price'] = $day_price;
    $data['day_cup_num'] = $day_cup_num;
    return $data;
}
