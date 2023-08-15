<?php
namespace app\common\api;
use app\common\api\Base;
use nfutil\Tree;


/**
 * 用户内部接口
 */
class Module extends Base
{   


    // +----------------------------------------------------------------------
    // | 权限
    // +----------------------------------------------------------------------

    /**
     * 检查部门功能权限
     * 判断当前用户是否有权访问当前地址
     */
    public function checkMenuAuth($menu = 'admin_menu')
    {
        $current_menu = $this->getCurrentMenu('', $menu); // 当前菜单
        $user_group   = D2('AdminAccess')->getFieldByUid(session('user_auth.uid'), 'group'); // 获得当前登录用户信息
        if ($user_group !== '1') {
            $group_info = D2('AdminGroup')->find($user_group);
            // 获得当前登录用户所属部门的权限列表
            $group_auth = json_decode($group_info['menu_auth'], true);
            if (in_array($current_menu['id'], $group_auth[ucfirst(request()->module())])) {
                return true;
            }
        } else {
            return true; // 超级管理员无需验证
        }
        return false;
    }

    /**
     * 检查部门功能权限
     * 未启用
     */
    public function checkUserNavAuth()
    {
        return $this->checkMenuAuth('user_nav');
    }

    /**
     * 获取模块当前菜单
     * 获得【功能模块】中指定模块的指定菜单
     */
    public function getCurrentMenu($module_name = '',$menu = 'admin_menu')
    {
        if ('' == $module_name) {
            $module_name = request()->module();
        }
        $admin_menu = D2('AdminModule')->getFieldByName(ucfirst($module_name), $menu);
        $admin_menu = json_decode($admin_menu, true);
        if($menu == 'user_nav'){
            $admin_menu_list = $admin_menu;
            foreach($admin_menu_list as $key => $admin_menu){
                $res = $this->_getCurrentMenu($admin_menu);
                if($res){
                    $nav['title'] = $key;
                    $nav['menu'] = $res;
                    return $nav;
                }
            }
        }else
            return $this->_getCurrentMenu($admin_menu);
    }
    public function _getCurrentMenu($admin_menu){
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
     * 获取用户后台导航
     * 用户后台导航菜单，没有进行权限控制
     */
    public function getAllMenuUserNav($module_name)
    {
        $uid        = is_login();
        $list = S('MODULE_USER_NAV_'.$uid);
        if (!$list || APP_DEBUG === true) {
            $con['status']      = 1;
            $con['name'] = $module_name;
            $system_module = D2('AdminModule')->where($con)->order('sort asc, id asc')->find();
            $tree = new tree();
            $user_nav = json_decode($system_module['user_nav'], true);
            foreach($user_nav as $k => $v){
                $temp = $tree->list2tree($v);
                $menu_list = array();
                $menu_list[$k] = $temp[0];
                $menu_list[$k]['id']   = $temp[0]['id'];
                $menu_list[$k]['name'] = $k;
                // 如果模块顶级菜单配置了top字段则移动菜单至top所指的模块下边
                foreach ($menu_list as $key => &$value) {
                    if ($value['top']) {
                        if ($menu_list[$value['top']]) {
                            $menu_list[$value['top']]['_child'] = array_merge(
                                $menu_list[$value['top']]['_child'],
                                $value['_child']
                            );
                            unset($menu_list[$key]);
                        }
                    }
                }
                $list[$k] = $menu_list[$k];
            }

            S('MODULE_USER_NAV_'.$uid, $list, 3600);  // 缓存配置
        }

        return $list;
    }


    /**
     * 根据菜单ID的获取其所有父级菜单
     * @param array $current_menu 当前菜单信息
     * @return array 父级菜单集合
     * 
     */
    public function getParentMenu($current_menu = '', $module_name = '',$menu = 'admin_menu')
    {
        if ('' == $module_name) {
            $module_name = request()->module();
        }
        if (!$current_menu) {
            $current_menu = $this->getCurrentMenu('',$menu);
        }
        if (!$current_menu) {
            return false;
        }

        $admin_menu = D2('AdminModule')->getFieldByName(ucfirst($module_name), $menu);
        $admin_menu = json_decode($admin_menu, true);
        if($menu == 'user_nav'){
            $title = $current_menu['title'];
            $admin_menu = $admin_menu[$title];
            $current_menu = $current_menu['menu'];
        }
        $pid        = $current_menu['pid'];
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
        if($menu == 'user_nav'){
            $res['title'] = $title;
            $res['menu'] = $result;
            return $res;
        }
        return $result;
    }




}
