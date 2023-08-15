<?php
namespace app\ads\admin;
use app\admin\controller\Admin;
use nfutil\Page;

/**
 * 广告
 * 
 */
class Ads extends Admin {
    
    /**
     * 广告
     * 
     */
    public function index() {
        $where['category'] = 1;
        API('Ads')->index($where);        
    }

    /**
     * 新增
     * 
     */
    public function add()
    {
        $res = API('Ads')->add();
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
