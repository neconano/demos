<?php
namespace app\home\controller;

use app\common\controller\Controller;
use nfutil\Verify;
use think\Env;

/**
 * 后台唯一不需要权限验证的控制器
 * 
 */
class Login extends Controller
{
    /**
     * 后台登陆
     * 
     */
    public function login()
    {
        if (is_login()) {
            $this->redirect('admin/index');
        }
        if (request()->isPost()) {
            $username = I('username');
            $password = I('password');

            // 图片验证码校验
            if (!$this->checkVerify(I('post.verify')) && 'localhost' !== request()->hostname() && '127.0.0.1' !== request()->hostname()) {
                $this->error('验证码输入错误！');
            }

            // 验证用户名密码是否正确
            $user_object = D2('AdminUser');
            $user_info   = $user_object->login($username, $password);
            if (!$user_info) {
                $this->error($user_object->getError());
            }

            // 设置登录状态
            $uid = $user_object->auto_login($user_info);

            // 跳转
            if ($uid > 0) {
                $this->success('登录成功！', U('admin/index'));
            } else {
                $this->logout();
            }
        } else {
            $this->assign('meta_title', '管理员登录');
            $this->display();
        }
    }

    /**
     * 注销
     * 
     */
    public function logout()
    {
        session('user_auth', null);
        session('user_auth_sign', null);
        $this->success('退出成功！', U('login'));
    }

    /**
     * 图片验证码生成，用于登录和注册
     * 
     */
    public function verify($vid = 1)
    {
        $verify = new Verify();
        $verify->fontSize = 38;
        $verify->length   = 3;
        // $verify->useNoise = false;
        $verify->codeSet = '0123456789'; 
        $verify->useCurve = false;
        $verify->entry($vid);
    }

    /**
     * 检测验证码
     * @param  integer $id 验证码ID
     * @return boolean 检测结果
     */
    protected function checkVerify($code, $vid = 1)
    {
        $verify = new Verify();
        return $verify->check($code, $vid);
    }


    
}
