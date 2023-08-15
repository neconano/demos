<?php
namespace app\common\behavior;

use think\Hook;
use think\Config;

defined('THINK_PATH') or exit();

/**
 * 初始化钩子信息
 * 
 */
class InitHook
{
    /**
     * 行为扩展的执行入口必须是run
     * 
     */
    public function run(&$content)
    {
        // 添加插件配置
        $addon_config['addon_path']                        = ADDON_PATH;
        $addon_config['view_replace_str']                  = config('view_replace_str');
        $addon_config['view_replace_str']['__ADDON_DIR__'] = C('TOP_HOME_PAGE') . '/addon';
        config($addon_config);
        \think\Loader::addNamespace('addon', $addon_config['addon_path']);

        $data = cache('hooks');
        if (!$data || config('app_debug') === true) {
            $hooks = D2('AdminHook')->getField('name,addons');
            foreach ($hooks as $hook => $value) {
                if ($value) {
                    $map['status'] = 1;
                    $names         = explode(',', $value);
                    $map['name']   = array('IN', $names);
                    $data          = D2('AdminAddon')->where($map)->getField('id,name');
                    if ($data) {
                        // 过滤掉插件目录不存在的插件
                        foreach ($data as $key => $val) {
                            $val = lcfirst($val);
                            if (!is_dir( ADDON_PATH . $val)) {
                                unset($data[$key]);
                            }
                        }
                        $addons = array_intersect($names, $data);
                        Hook::add($hook, array_map('get_addon_class', $addons));
                    }
                }
            }
            cache('hooks', Hook::get(), 60);
        } else {
            Hook::import($data, false);
        }
    }
}
