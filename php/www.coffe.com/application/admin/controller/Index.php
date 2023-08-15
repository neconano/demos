<?php
namespace app\admin\controller;

/**
 * 后台默认控制器
 * 
 */
class Index extends Admin
{

    /**
     * 删除缓存
     * 
     */
    public function removeRuntime()
    {
        $file   = new \nfutil\File();
        $result = $file->del_dir(RUNTIME_PATH);
        if ($result) {
            $this->success("缓存清理成功");
        } else {
            $this->error("缓存清理失败");
        }
    }
}
