<?php
namespace app\common\model;

/**
 * 管理员与用户组对应关系模型
 * 
 */
class AdminAccess extends Model3
{
    /**
     * 数据库表名
     * 
     */
    protected $tableName = 'admin_access';

    /**
     * 自动验证规则
     * 
     */
    protected $_validate = array(
        array('uid', 'require', 'UID不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('group', 'require', '部门不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('uid', 'checkUser', '该用户不存在', self::MUST_VALIDATE, 'callback', self::MODEL_BOTH),
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
     * 检查用户是否存在
     * 
     */
    protected function checkUser($uid)
    {
        $user_info = D2('AdminUser')->find($uid);
        if ($user_info) {
            return true;
        }
        return false;
    }
}
