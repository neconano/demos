<?php
namespace app\admin\controller;

use app\common\controller\Controller;

/**
 * 后台公共控制器
 * 
 */
class Admin extends Controller
{
    public $is_invoke = 0;

    /**
     * 初始化方法
     * 
     */
    protected function _initialize()
    {

        if(S('ACCESS')){
            $this->is_invoke = 1;
            return;
        }

        // 登录检测
        if (!is_login()) {
            //还没登录跳转到登录页面
            $this->redirect('admin/Login/login');
        }

        // 获取当前访问地址
        $current_url = request()->module() . '/' . request()->controller() . '/' . request()->action();
        // 权限检测，首页不需要权限
        if ('admin/admin/index' !== strtolower($current_url)) {
            if (!API('Module')->checkMenuAuth()) {
                $this->error('权限不足！', url('admin/admin/index'));
            }
            $this->assign('_admin_tabs', config('admin_tabs'));
            $this->assign('lock_url', U('admin/admin/index') );
        }
        
        // 
        foreach(I('') as $k=>$v){
            $this->assign($k,$v);
        }

        // 设置后台display标记
        S('admin_menu_mark','admin_menu');

        return parent::_initialize();
    }

    // API调用返回实例
    public function get_instance(){
        return $this;
    }

    /**
     * 默认方法
     * 
     */
     public function index()
     {
        $this->assign('meta_title', "首页");
        $this->display();
     }
 
    /**
     * 模块配置方法
     * 
     */
    public function module_config()
    {
        if (request()->isPost()) {
            $id     = (int) I('id');
            $config = input('config');
            $flag   = D2('AdminModule')
                ->where("id={$id}")
                ->setField('config', json_encode($config));
            if ($flag !== false) {
                $this->success('保存成功');
            } else {
                $this->error('保存失败');
            }
        } else {
            $name        = request()->module();
            $config_file = realpath(APP_DIR . $name) . '/' . D2('AdminModule')->install_file();
            if (!$config_file) {
                $this->error('配置文件不存在');
            }
            $module_config = include $config_file;

            $module_info = D2('AdminModule')->where(array('name' => $name))->find($id);
            $db_config   = $module_info['config'];

            // 构造配置
            if ($db_config) {
                $db_config = json_decode($db_config, true);
                foreach ($module_config['config'] as $key => $value) {
                    if ($value['type'] != 'group') {
                        $module_config['config'][$key]['value'] = $db_config[$key];
                    } else {
                        foreach ($value['options'] as $gourp => $options) {
                            foreach ($options['options'] as $gkey => $value) {
                                $module_config['config'][$key]['options'][$gourp]['options'][$gkey]['value'] = $db_config[$gkey];
                            }
                        }
                    }
                }
            }

            // 构造表单名
            foreach ($module_config['config'] as $key => $val) {
                if ($val['type'] == 'group') {
                    foreach ($val['options'] as $key2 => $val2) {
                        foreach ($val2['options'] as $key3 => $val3) {
                            $module_config['config'][$key]['options'][$key2]['options'][$key3]['name'] = 'config[' . $key3 . ']';
                        }
                    }
                } else {
                    $module_config['config'][$key]['name'] = 'config[' . $key . ']';
                }
            }

            // 使用FormBuilder快速建立表单页面
            $builder = new \nfutil\builder\FormBuilder();
            $builder->setMetaTitle('设置') //设置页面标题
                ->setPostUrl(url('')) //设置表单提交地址
                ->addFormItem('id', 'hidden', 'ID', 'ID')
                ->setExtraItems($module_config['config']) //直接设置表单数据
                ->setFormData($module_info)
                ->display();
        }
    }

    
    /**
     * 切换开关类型状态
     * 
     */
    public function toggle($name)
    {
        $this->error('禁止使用');
        $con          = array();
        $con['type']  = 'toggle';
        $con['name']  = $name;
        $config_model = D2('AdminConfig');
        $info         = $config_model->where($con)->find();
        if (!$info) {
            $this->error('不存在该配置');
        }
        if ($info['value'] == '1') {
            $result = $config_model->where($con)->setField('value', '0');
            if ($result) {
                $this->success('关闭' . $info['title'] . '成功');
            } else {
                $this->error('关闭' . $info['title'] . '失败' . $config_model->getError());
            }
        }
        if ($info['value'] == '0') {
            $result = $config_model->where($con)->setField('value', '1');
            if ($result) {
                $this->success('开启' . $info['title'] . '成功');
            } else {
                $this->error('开启' . $info['title'] . '失败' . $config_model->getError());
            }
        }
    }

    /**
     * KindEditor编辑器文件管理
     * 
     */
    public function fileManager()
    {
        exit(D2('AdminUpload')->fileManager());
    }

    /**
     * 上传
     * 
     */
    public function upload()
    {
        $return = json_encode(D2('AdminUpload')->upload());
        exit($return);
    }

}
