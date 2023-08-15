<?php
namespace app\common\api;

use think\Config;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;
use think\Url;

/**
 * 内部接口基类
 */
class Base extends \think\Controller
{   
    protected $res;

    public function _initialize(){
        return parent::_initialize();
    }

    // API调用返回实例
    public function get_instance(){
        return $this;
    }

    // 标准返回
    public function std_return($status,$data,$msg){
        $this->res['status'] = $status;
        $this->res['msg'] = $msg;
        $this->res['data'] = $data;
        return $this->res;
    }

    // 标准正常返回
    public function res_good($data=[],$msg=''){
        return $this->std_return(true,$data,$msg);
    }

    // 标准异常返回
    public function res_bad($msg='',$data=[]){
        return $this->std_return(false,$data,$msg);
    }
    
}
