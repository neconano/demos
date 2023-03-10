<?php
namespace app\common\model;
use nfutil\Tree;

/**
 * 功能模块模型
 * 
 */
class AdminModule extends Model3
{
    /**
     * 数据库表名
     * 
     */
    protected $tableName = 'admin_module';

    /**
     * 自动验证规则
     * 
     */
    protected $_validate = array(
        array('name', 'require', '模块名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('name', '', '该模块已存在', self::MUST_VALIDATE, 'unique', self::MODEL_BOTH),
        array('title', 'require', '模块标题不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('description', 'require', '模块描述不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('developer', 'require', '模块开发者不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('version', 'require', '模块版本不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('admin_menu', 'require', '模块菜单节点不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    /**
     * 自动完成规则
     * 
     */
    protected $_auto = array(
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
        array('sort', '0', self::MODEL_INSERT),
        array('status', '1', self::MODEL_INSERT),
    );

    /**
     * 安装描述文件名
     * 
     */
    public function install_file()
    {
        return 'setting.php';
    }

    /**
     * 获取模块菜单
     * 
     */
    public function getAdminMenu($module_name = '')
    {
        if ('' == $module_name) {
            $module_name = request()->module();
        }

        // 获取模块左侧导航
        $where['name']   = $module_name;
        $module_info     = $this->where($where)->find();
        $_side_menu_list = json_decode($module_info['admin_menu'], true);

        // 转换成树结构
        $tree = new tree();
        return $tree->list2tree($_side_menu_list);
    }

    /**
     * 获取模块当前菜单
     * 
     */
    public function getCurrentMenu($module_name = '')
    {
        if ('' == $module_name) {
            $module_name = request()->module();
        }
        $admin_menu = $this->getFieldByName(ucfirst($module_name), 'admin_menu');
        $admin_menu = json_decode($admin_menu, true);
        foreach ($admin_menu as $key => $val) {
            if (isset($val['url'])) {
                $config_url  = U(lcfirst($val['url']));
                $current_url = U(request()->module() . '/' . request()->controller() . '/' . request()->action());
                if ($config_url === $current_url) {
                    $result = $val;
                    return $result;
                }
            }
        }
    }

    /**
     * 获取所有模块菜单
     * @param string $addon_dir
     * 
     */
    public function getAllMenu()
    {
        $uid        = is_login();
        $user_group = D2('AdminAccess')->getFieldByUid($uid, 'group'); // 获得当前登录用户信息
        $group_info = D2('AdminGroup')->find($user_group);
        $group_auth = json_decode($group_info['menu_auth'], true); // 获得当前登录用户所属部门的权限列表

        // 获取所有菜单
        $menu_list = S('MENU_LIST_' . $uid);
        if (!$menu_list || APP_DEBUG === true) {
            $con['status']      = 1;
            $system_module_list = $this->where($con)->order('sort asc, id asc')->select();
            $tree               = new tree();
            $menu_list          = array();
            foreach ($system_module_list as $key => &$module) {
                $menu = json_decode($module['admin_menu'], true);

                // 判断当前用户组的权限是否包含当前模块
                if (isset($group_auth[$module['name']]) || $user_group === '1') {
                    if ($user_group !== '1') {
                        $menu_tmp     = array();
                        $menu_tmp_tmp = array();
                        foreach ($menu as $key1 => &$val1) {
                            if (in_array($val1['id'], $group_auth[$module['name']]) && $val1['pid'] !== '0') {
                                $menu_tmp[$val1['id']] = $menu[$key1];
                            }
                        }
                        if (count($menu_tmp) > 0) {
                            foreach ($menu_tmp as $key2 => &$val2) {
                                $_pid = $val2['pid'];
                                do {
                                    if (!isset($menu_tmp[$menu[$_pid]['id']])) {
                                        $menu_tmp_tmp[$menu[$_pid]['id']] = $menu[$_pid];
                                    }
                                    $_pid = $menu[$_pid]['pid'];
                                } while ($_pid > 0);
                            }
                            $menu = array_merge($menu_tmp, $menu_tmp_tmp);
                        }
                    }

                    $temp = $tree->list2tree($menu);
                    if (isset($temp[0])) {
                        $menu_list[$module['name']]         = $temp[0];
                        $menu_list[$module['name']]['id']   = $module['id'];
                        $menu_list[$module['name']]['name'] = $module['name'];
                    }
                }
            }
            // 过滤导航
            $menu_list = API("Access")->checkMenuAuth($menu_list);
            // 如果模块顶级菜单配置了top字段则移动菜单至top所指的模块下边
            foreach ($menu_list as $key => &$value) {
                if (isset($value['top'])) {
                    if ($menu_list[$value['top']]) {
                        $menu_list[$value['top']]['_child'] = array_merge(
                            $menu_list[$value['top']]['_child'],
                            $value['_child']
                        );
                        unset($menu_list[$key]);
                    }
                }
            }

            S('MENU_LIST_' . $uid, $menu_list, 3600); // 缓存配置
        }
        return $menu_list;
    }

    /**
     * 根据菜单ID的获取其所有父级菜单
     * @param array $current_menu 当前菜单信息
     * @return array 父级菜单集合
     * 
     */
    public function getParentMenu($current_menu = '', $module_name = '')
    {
        if ('' == $module_name) {
            $module_name = request()->module();
        }
        if (!$current_menu) {
            $current_menu = $this->getCurrentMenu();
        }
        if (!$current_menu) {
            return false;
        }
        $admin_menu = $this->getFieldByName(ucfirst($module_name), 'admin_menu');
        $admin_menu = json_decode($admin_menu, true);
        $pid        = $current_menu['pid'];
        $temp       = array();
        $result[]   = $current_menu;
        while (true) {
            foreach ($admin_menu as $key => $val) {
                if ($val['id'] == $pid) {
                    $pid = $val['pid'];
                    array_unshift($result, $val); // 将父菜单插入到第一个元素前
                }
            }
            if ($pid == '0') {
                break;
            }
        }
        return $result;
    }

    /**
     * 获取模块列表
     * @param string $addon_dir
     * 
     */
    public function getAll()
    {
        // 获取除了Common等系统模块外的用户模块
        // 文件夹下必须有$install_file定义的安装描述文件
        $dirs = array_map('basename', glob(APP_DIR . '*', GLOB_ONLYDIR));
        foreach ($dirs as $dir) {
            $config_file = APP_DIR . $dir . '/' . $this->install_file();
            if (is_file($config_file)) {
                $module_dir_list[]                      = $dir;
                $temp_arr                               = include $config_file;
                $temp_arr['info']['status']             = -1; //未安装
                $module_list[$temp_arr['info']['name']] = $temp_arr['info'];
            }
        }

        // 获取系统已经安装的模块信息
        $installed_module_list = $this->field(true)
            ->order('sort asc,id asc')
            ->select();
        if ($installed_module_list) {
            foreach ($installed_module_list as &$module) {
                $new_module_list[$module['name']]               = $module;
                $new_module_list[$module['name']]['admin_menu'] = json_decode($module['admin_menu'], true);
            }
            // 系统已经安装的模块信息与文件夹下模块信息合并
            $module_list = array_merge($module_list, $new_module_list);
        }

        foreach ($module_list as &$val) {
            switch ($val['status']) {
                case '-2': // 损坏
                    $val['status_icon']                          = '<span class="text-danger">删除记录</span>';
                    $val['right_button']['damaged']['title']     = '删除记录';
                    $val['right_button']['damaged']['attribute'] = 'class="label label-danger-outline label-pill ajax-get" href="' . U('setStatus', array('status' => 'delete', 'ids' => $val['id'])) . '"';
                    break;
                case '-1': // 未安装
                    $val['status_icon']                                 = '<i class="fa fa-download text-success"></i>';
                    $val['right_button']['install_before']['title']     = '安装';
                    $val['right_button']['install_before']['attribute'] = 'class="label label-success-outline label-pill" href="' . U('install_before', array('name' => $val['name'])) . '"';
                    break;
                case '0': // 禁用
                    $val['status_icon']                                   = '<i class="fa fa-ban text-danger"></i>';
                    $val['right_button']['update_info']['title']          = '更新菜单';
                    $val['right_button']['update_info']['attribute']      = 'class="label label-info-outline label-pill ajax-get no-refresh" href="' . U('updateInfo', array('id' => $val['id'])) . '"';
                    $val['right_button']['forbid']['title']               = '启用';
                    $val['right_button']['forbid']['attribute']           = 'class="label label-success-outline label-pill ajax-get" href="' . U('setStatus', array('status' => 'resume', 'ids' => $val['id'])) . '"';
                    $val['right_button']['uninstall_before']['title']     = '卸载';
                    $val['right_button']['uninstall_before']['attribute'] = 'class="label label-danger-outline label-pill " href="' . U('uninstall_before', array('id' => $val['id'])) . '"';
                    break;
                case '1': // 正常
                    $val['status_icon']                              = '<i class="fa fa-check text-success"></i>';
                    $val['right_button']['update_info']['title']     = '更新菜单';
                    $val['right_button']['update_info']['attribute'] = 'class="label label-info-outline label-pill ajax-get no-refresh" href="' . U('updateInfo', array('id' => $val['id'])) . '"';
                    if (!$val['is_system']) {
                        $val['right_button']['forbid']['title']               = '禁用';
                        $val['right_button']['forbid']['attribute']           = 'class="label label-warning-outline label-pill ajax-get" href="' . U('setStatus', array('status' => 'forbid', 'ids' => $val['id'])) . '"';
                        $val['right_button']['uninstall_before']['title']     = '卸载';
                        $val['right_button']['uninstall_before']['attribute'] = 'class="label label-danger-outline label-pill " href="' . U('uninstall_before', array('id' => $val['id'])) . '"';
                    }
                    break;
            }
        }
        return $module_list;
    }

    /**
     * 获取模块名称列表
     * @param string $addon_dir
     * 
     */
    public function getNameList()
    {
        $list = $this->getField('name', true);
        foreach ($list as $val) {
            $return[$val] = $val;
        }
        return $return;
    }



    /**
     * 获取模块当前菜单
     */
    public function getCurrentMenu2URL($module_name, $url) {
        $admin_menu = $this->getFieldByName($module_name, 'admin_menu');
        $admin_menu = json_decode($admin_menu, true);
        $current_url = U($url);
        foreach ($admin_menu as $key => $val) {
            if (isset($val['url'])) {
                $config_url  = U($val['url']);
                // 如果绑定模型，且导航不是对应模型，不显示
                if ( defined('BIND_MODULE') && $val['model'] !== BIND_MODULE )
                    return false;
                if ($config_url === $current_url) {
                    $result = $val;
                }
            }
        }
        return $result;
    }











}
