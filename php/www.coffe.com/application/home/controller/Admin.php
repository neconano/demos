<?php
namespace app\home\controller;
use app\common\controller\Controller;

/**
 * 后台控制器基类
 * 用户后台操作必须继承该类
 */
class Admin extends Controller
{

    /**
     * 初始化方法
     * 
     */
    protected function _initialize()
    {
        // 登录检测
        if (!is_login()) {
            $this->redirect('Login/login');
        }

        // 设置后台display标记
        S('admin_menu_mark','user_nav');

        // 在多标签模式下，防止跳出后台框架
        $current_url = request()->module() . '/' . request()->controller() . '/' . request()->action();
        if ( strtolower(request()->module() . '/admin/index') !== strtolower($current_url)) {
            $this->assign('_admin_tabs', config('admin_tabs'));
            $this->assign('lock_url', U('admin/index') );
        }

        return parent::_initialize();
    }

    /**
     * 切换开关类型状态
     * 
     */
    public function toggle($name)
    {
        $this->error('禁止使用');
    }


    // 显示后台默认页
    public function index(){
        $this->data_list();
    }

    public function customer_list(){
        A2A('index')->customer_list();
    }
    
    public function coupon_list(){
        A2A('index')->coupon_list();
    }

    public function push_coupon(){
        A2A('index')->push_coupon();
        $this->display('admin/index/push_coupon');
    }

    public function pay_log(){
        A2A('index')->pay_log();
    }

    // public function coupon_manage(){
    //     A2A('index')->coupon_manage();
    // }
    
    // public function coupon_edit(){
    //     A2A('index')->coupon_edit();
    // }

    public function device_list(){
        A2A('index')->device_list();
    }
    
    public function data_list(){
        A2A('index')->data_list();
        $this->display('admin/index/data_list');
    }

    public function device_trouble_list(){
        A2A('index')->device_trouble_list();
    }

    public function free_code_list(){
        A2A('index')->free_code_list();
    }

    public function make_free_code(){
        A2A('index')->make_free_code();
    }
    
    public function push_free_code(){
        A2A('index')->push_free_code();
        $this->display('admin/index/push_free_code');
    }
    
    public function make_qrcode(){
        A2A('index')->make_qrcode();
        $this->display('admin/index/make_qrcode');
    }

    public function device_detail(){
        A2A('index')->device_detail();
    }

    public function device_tune_list(){
        A2A('index')->device_tune_list();
    }

    public function tune_detail(){
        A2A('index')->tune_detail();
    }

    public function model2status(){
        A2A('index')->model2status();
    }
    
    public function finance_info(){
        A2A('index')->user_money_record($this->uid);
    }
    
    public function user_card(){
        A2A('index')->user_card($this->uid);
    }

    public function cash_out(){
        if(IS_POST){
            $post['money'] = I('money');
            $post['uid'] = $this->uid;
            $getRes = API('Coffee')->cash_out($post);
            $this->std_return($getRes);
        }
        $www['uid'] = $this->uid;
        $user_setting = M('cf_user_info',null)->where($www)->find();
        // 提现频率
        $ww2w['uid'] = $this->uid;
        $ww2w['opt_type'] = '提现';
        $info = M('cf_user_money_record',null)->where($ww2w)->order('date_time desc')->find();
        $av_time = strtotime($info['date_time'])+24*60*60*$user_setting['rate_pay'];
        if($info && $av_time - time() > 0 ){
            $ret['status'] = false;
            $ret['msg'] = '请'.date('Y-m-d H:i:s',$av_time).'后再提现';
            $this->std_return($ret);
        }
        $this->assign('user_setting', $user_setting);
        $this->display('admin/index/cash_out');
    }


    /**
     * 编辑用户
     * 
     */
    public function change_password()
    {
        if (request()->isPost()) {
            // 密码为空表示不修改密码
            if ($_POST['password'] === '') {
                unset($_POST['password']);
            }
            // 提交数据
            $user_object = D2('AdminUser');
            $data        = $user_object->create();
            if ($data) {
                $data['id'] = is_login();
                $result = $user_object
                    ->field('id,nickname,username,password,email,email_bind,mobile,mobile_bind,gender,avatar,update_time')
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
            $id = is_login();
            // 获取账号信息
            $info = D2('AdminUser')->find($id);
            unset($info['password']);
            // 使用FormBuilder快速建立表单页面
            $builder = new \nfutil\builder\FormBuilder();
            $builder->setMetaTitle('编辑用户') // 设置页面标题
                ->setPostUrl(U('')) // 设置表单提交地址
                ->addFormItem('id', 'hidden', 'ID', 'ID')
                ->addFormItem('nickname', 'hidden', '昵称', '昵称')
                ->addFormItem('username', 'hidden', '用户名', '用户名')
                ->addFormItem('password', 'text', '密码', '密码')
                ->addFormItem('email', 'hidden', '邮箱', '邮箱')
                ->addFormItem('email_bind', 'hidden', '邮箱绑定', '手机绑定', array('1' => '已绑定', '0' => '未绑定'))
                ->addFormItem('mobile', 'text', '手机号', '手机号')
                ->addFormItem('mobile_bind', 'hidden', '手机绑定', '手机绑定', array('1' => '已绑定', '0' => '未绑定'))
                ->addFormItem('avatar', 'hidden', '头像', '头像')
                ->setFormData($info)
                ->display();
        }
    }


}
