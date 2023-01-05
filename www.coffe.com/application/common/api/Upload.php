<?php
namespace app\common\api;
use app\common\api\Base;
/**
 * 
 */
class Upload extends Base
{   
    // 获得图片
    public function get_pic($img_id=''){
        $list = D2('AdminUpload')->select();
        $new = make_k_v_array($list,'id','path');
        if($img_id)
        return $new[$img_id];
        return $new;
    }


}
