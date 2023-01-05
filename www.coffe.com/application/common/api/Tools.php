<?php
namespace app\common\api;
use app\common\api\Base;
/**
 * 用户内部接口
 */
class Tools extends Base
{   

    /**
     * 上传
     * 
     */
    public function upload()
    {
        if (is_login() || (C('AUTH_KEY') === $_SERVER['HTTP_UPLOADTOKEN'])) {
            // 上传图片
            $return = json_encode(D2('AdminUpload')->upload());

            // 如果是跨域上传需要回调处理
            if ($_SERVER['HTTP_ORIGIN'] !== request()->domain() && $_GET['callback_type']) {
                switch ($_GET['callback_type']) {
                    case 'kindeditor':
                        redirect($_SERVER['HTTP_ORIGIN'] . __ROOT__ . '/public/libs/kindeditor/callback.php?json=' . $return);
                        break;
                    case 'editormd':
                        redirect($_SERVER['HTTP_ORIGIN'] . __ROOT__ . '/public/libs/editormd/callback.html?json=' . $return);
                        break;
                }
            } else {
                exit($return);
            }
        }
    }


    /**
     * 下载
     * 
     */
    public function download($token)
    {
        $this->is_login();

        if (empty($token)) {
            $this->error('token参数错误！');
        }

        //解密下载token
        $file_md5 = \nfutil\Crypt::decrypt($token, user_md5(is_login()));
        if (!$file_md5) {
            $this->error('下载链接已过期，请刷新页面！');
        }

        $upload_object = D2('AdminUpload');
        $file_id       = $upload_object->getFieldByMd5($file_md5, 'id');
        if (!$upload_object->download($file_id)) {
            $this->error($upload_object->getError());
        }
    }



}
