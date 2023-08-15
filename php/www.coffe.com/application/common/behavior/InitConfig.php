<?php
namespace app\common\behavior;
use think\Env;

defined('THINK_PATH') or exit();

class InitConfig
{
    /**
     * 行为扩展的执行入口必须是run
     * 
     */
    public function run(&$content)
    {
        // 读取数据库中的配置
        $system_config = cache('db_config_data');
        if (!$system_config || config('app_debug') === true) {
            
            // 获取所有系统配置
            $system_config = D2('AdminConfig')->lists();

            // 加载模块标签库及行为扩展
            $system_config['template']        = C('template'); // 先取出配置文件中定义的否则会被覆盖
            $system_config['taglib_pre_load'] = explode(',', $system_config['template']['taglib_pre_load']); // 先取出配置文件中定义的否则会被覆盖

            // 获取所有安装的模块配置
            $module_list = D2('AdminModule')->where(array('status' => '1'))->select();
            foreach ($module_list as $_module) {
                // 将模块自定义的配置合并到全局配置
                $module_config[strtolower($_module['name'] . '_config')]['module_name'] = $_module['name'];
                $module_config[strtolower($_module['name'] . '_config')]                = json_decode($_module['config'], true);

                // 加载模块标签库
                $tag_path = APP_DIR . $_module['name'] . '/taglib/' . $_module['name'] . '.php';
                if (is_file($tag_path)) {
                    $system_config['taglib_pre_load'][] = $_module['name'] . '\\taglib\\' . $_module['name'];
                }

                // 加载模块行为扩展
                $bhv_path = APP_DIR . $_module['name'] . '/behavior/' . $_module['name'] . 'Behavior.php';
                if (is_file($bhv_path)) {
                    \think\Hook::add('nf_behavior', $_module['name'] . '\\behavior\\' . $_module['name'] . 'Behavior');
                }
            }
            if ($module_config) {
                // 合并模块配置
                $system_config = array_merge($system_config, $module_config);
            }

            // 获取所有安装的插件配置
            $addon_list = D2('AdminAddon')->where(array('status' => '1'))->select();
            foreach ($addon_list as $_addon) {
                // 将插件自定义的配置合并到全局配置
                $addon_config[strtolower($_addon['name'] . '_addon_config')]['addon_name'] = $_addon['name'];
                $addon_config[strtolower($_addon['name'] . '_addon_config')]               = json_decode($_addon['config'], true);

                // 加载插件标签库
                $tag_path = config('addon_path') . lcfirst($_addon['name']) . '/taglib/' . $_addon['name'] . 'Addon.php';
                if (is_file($tag_path)) {
                    $system_config['taglib_pre_load'][] = '\\addon\\' . lcfirst($_addon['name']) . '\\taglib\\' . $_addon['name'] . 'Addon';
                }

                // 加载插件行为扩展
                $bhv_path = config('addon_path') . lcfirst($_addon['name']) . '/behavior/' . $_addon['name'] . 'Addon.php';
                if (is_file($bhv_path)) {
                    \think\Hook::add('nf_behavior', '\\addon\\' . lcfirst($_addon['name']) . '\\behavior\\' . $_addon['name'] . 'Addon');
                }
            }
            if ($addon_config) {
                // 合并模块配置
                $system_config = array_merge($system_config, $addon_config);
            }

            // 格式化加载标签库
            $system_config['template']['taglib_pre_load'] = implode(',', $system_config['taglib_pre_load']);

            // 加载Formbuilder扩展类型
            $system_config['form_item_type'] = C('form_item_type');
            $formbuilder_extend              = explode(',', D2('AdminHook')->getFieldByName('FormBuilderExtend', 'addons'));
            if ($formbuilder_extend) {
                $addon_object = D2('AdminAddon');
                foreach ($formbuilder_extend as $val) {
                    $temp = json_decode($addon_object->getFieldByName($val, 'config'), true);
                    if ($temp['status']) {
                        $form_type[$temp['form_item_type_name']] = array($temp['form_item_type_title'], $temp['form_item_type_field']);
                        $system_config['form_item_type']         = array_merge($system_config['form_item_type'], $form_type);
                    }
                }
            }

            cache('db_config_data', $system_config, 3600); // 缓存配置
        }

        // 移动端强制后台传统视图
        if (request()->isMobile()) {
            $system_config['admin_tabs'] = 0;
        }

        // 如果是后台并且不是Admin模块则设置默认控制器层为Admin
        if (MODULE_MARK === 'Admin' && request()->module() !== '' && request()->module() !== 'admin') {
            $system_config['url_controller_layer']  = 'admin';
            $system_config['template']['view_path'] = APP_DIR . request()->module() . '/view/admin/';
        }

        C($system_config); // 添加配置
    }
}
