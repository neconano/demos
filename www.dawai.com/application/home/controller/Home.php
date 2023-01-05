<?php
namespace app\home\controller;
use app\common\controller\Controller;
use think\Db;

/**
 * 前台公共控制器
 * 
 */
class Home extends Controller
{
    /**
     * 用户信息
     * 
     */
    protected $user_info;

    /**
     * 初始化方法
     * 
     */
    protected function _initialize()
    {
        // 监听行为扩展
        try {
            \Think\Hook::listen('nf_behavior');
        } catch (\Exception $e) {
            file_put_contents(RUNTIME_PATH . 'error.json', json_encode($e->getMessage()));
        }

    }

    /**
     * 发送验证码
     * @return mixed
     */
    public function send_code()
    {
        $phone=$this->request->post('tel');
        return API('Sendmessage')->send_code($phone);

    }

    /**
     * 验证码
     * @param $code
     * @return bool
     */
    public function check_code($code)
    {
        $res=Db::table('dw_tel_code')->where('code','=',$code)->find();
        if ($res) {
            return true;
        }else {
            return false;
        }
    }
}
