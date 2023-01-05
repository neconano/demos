<?php
namespace app\common\api;

use think\Config;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;
use think\Url;
use app\common\controller\Controller;

/**
 * 内部接口基类
 */
class Base extends Controller
{   
    protected $res;

    public function _initialize(){
        $this->_init();
        return parent::_initialize();
    }

    protected function _init(){
    }

    // API调用返回实例
    public function get_instance(){
        return $this;
    }

    // 标准返回
    public function api_return($status,$data,$msg){
        $this->res['status'] = $status;
        $this->res['msg'] = $msg;
        $this->res['data'] = $data;
        return $this->res;
    }

    // 标准正常返回
    public function res_good($data=[],$msg=''){
        return $this->api_return(true,$data,$msg);
    }

    // 标准异常返回
    public function res_bad($msg='',$data=[]){
        return $this->api_return(false,$data,$msg);
    }
    
}
