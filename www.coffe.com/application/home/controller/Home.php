<?php
namespace app\home\controller;
use app\common\controller\Controller;

/**
 * 前台公共控制器
 * 
 */
class Home extends Controller
{

    /**
     * 初始化方法
     */
    protected function _initialize()
    {
        // 监听行为扩展
        try {
            \Think\Hook::listen('nf_behavior');
        } catch (\Exception $e) {
            file_put_contents(RUNTIME_PATH . 'error.json', json_encode($e->getMessage()));
        }
        // 
        foreach(I('') as $k=>$v){
            $this->assign($k,$v);
        }
    }


}
