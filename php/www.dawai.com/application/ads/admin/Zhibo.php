<?php
namespace app\ads\admin;
use app\admin\controller\Admin;
use nfutil\Page;

/**
 * 直播
 * 
 */
class Zhibo extends Admin {
    
    /**
     * 广告
     * 
     */
    public function index() {
        API('Ads')->index(['category'=>2]);    
    }

    /**
     * 新增
     * 
     */
    public function add()
    {
        $res = API('Ads')->add(2);
        $this->std_return($res);
    }
 

    /**
     * 编辑
     * 
     */
     public function edit($id)
     {
        $res = API('Ads')->edit($id);
        $this->std_return($res);
     }
 











}
