<?php
namespace app\common\behavior;
use think\Env;

defined('THINK_PATH') or exit();

/**
 * 初始化允许访问模块信息
 * 
 */
class InitModule
{
    /**
     * 行为扩展的执行入口必须是run
     * 
     */
    public function run(&$content)
    {
        // 在Request请求对象中添加方法
        \think\Request::hook('hostname', 'hostname');

        // 获取配置
        $config = config();

        $module_allow_list = cache('module_allow_list');
        if(!$module_allow_list || config('app_debug') === true){
            // 允许访问模块列表加上安装的功能模块
            $module_name_list = D2('AdminModule')
                ->where(array('status' => 1, 'is_system' => 0))
                ->getField('name', true);
            $module_allow_list = array_merge(
                config('module_allow_list'),
                $module_name_list
            );
        }
        cache('module_allow_list', $module_allow_list, 60);

        if (MODULE_MARK === 'Admin') {
            $module_allow_list[] = 'admin';
            // 后台只输入{域名}/admin.php即可进入后台首页
            if ($_SERVER['PATH_INFO'] === null || $_SERVER['PATH_INFO'] === '/') {
                $_SERVER['PATH_INFO'] = 'admin/admin/index';
            }
        }
        config('module_allow_list', $module_allow_list);

        // 系统主页地址配置
        $config['top_home_page'] = request()->domain() . __ROOT__;

        // 模块初始化
        $pathinfo = explode('/', request()->pathinfo());
        request()->module(strtolower($pathinfo[0]));

        config($config);
    }
}
