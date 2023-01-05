<?php
namespace app\common\api;
use app\common\api\Base;
use think\Env;

/**
 * 权限
 */
class Access extends Base
{   

	//  返回有权访问的目录
    public function checkMenuAuth($menu_list) {
		foreach($menu_list as $key =>$menu){
			$i2 = -1;
			foreach($menu[_child] as $menu_2){
				// if($key != 'Debug') continue;
				$i2 ++;
				$i3 = -1;
				foreach($menu_2[_child] as $menu_3){
					$i3 ++;
					$url = $menu_3['url'];
					if(!$this->checkURLAuth($url)){
						unset($menu_list[$key][_child][$i2][_child][$i3]);
					}
				}
				if(empty($menu_list[$key][_child][$i2][_child]))
					unset($menu_list[$key][_child][$i2]);
			}
			if(empty($menu_list[$key][_child]))
				unset($menu_list[$key]);
		}
		return $menu_list;
    }

	//  判断访问权限
    public function checkURLAuth($url) {
        $user_group = D2('AdminAccess')->getFieldByUid(session('user_auth.uid'), 'group');  // 获得当前登录用户信息
		if ($user_group == '1'){
			// 如果是绑定入口，则只显示绑定导航
			if(defined('BIND_MODULE')){
				if(!$this->_checkURLAuth($url))
					return false;
			}
			return true;
		}
        $re = $this->_checkURLAuth($url);
		$current_menu = $re['current_menu'];
		$module_name = $re['module_name'];
		if(!$current_menu)
			return false;
		// 获得当前登录用户所属部门的权限列表
        $group_info = D2('AdminGroup')->find($user_group);	
		$group_auth = json_decode($group_info['menu_auth'], true);
		if (in_array($current_menu['id'], $group_auth[$module_name]))
			return true;
        return false;
	}

	// 获得url对应的配置项
    public function _checkURLAuth($url) {
		$list = D2('AdminModule')->field('name')->select();
		// 用户组对应地址记录
		foreach($list as $v){
			$module_name = $v['name'];
			$current_menu = D2('AdminModule')->getCurrentMenu2URL($module_name, $url);
			if($current_menu)
				break;
		}
		if(!$current_menu)
			return false;
		$re['current_menu'] = $current_menu;
		$re['module_name'] = $module_name;
		return $re;	
	}


}
