<?php
namespace app\common\model;

/**
 * 部门模型
 * 
 */
class AdminGroup extends Model3
{
    /**
     * 数据库表名
     * 
     */
    protected $tableName = 'admin_group';

    /**
     * 自动验证规则
     * 
     */
    protected $_validate = array(
        array('title', 'require', '部门名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('title', '1,32', '部门名称长度为1-32个字符', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH),
        array('title', '', '部门名称已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
        array('menu_auth', 'require', '权限不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    /**
     * 自动完成规则
     * 
     */
    protected $_auto = array(
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
        array('status', '1', self::MODEL_INSERT),
    );

    /**
     * 检查部门功能权限
     * 
     */
    // public function checkMenuAuth()
    // {
    //     $current_menu = D2('AdminModule')->getCurrentMenu(); // 当前菜单
    //     $user_group   = D2('AdminAccess')->getFieldByUid(session('user_auth.uid'), 'group'); // 获得当前登录用户信息
    //     if ($user_group !== '1') {
    //         $group_info = $this->find($user_group);
    //         // 获得当前登录用户所属部门的权限列表
    //         $group_auth = json_decode($group_info['menu_auth'], true);
    //         if (in_array($current_menu['id'], $group_auth[ucfirst(request()->module())])) {
    //             return true;
    //         }
    //     } else {
    //         return true; // 超级管理员无需验证
    //     }
    //     return false;
    // }



}
