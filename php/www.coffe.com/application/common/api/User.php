<?php
namespace app\common\api;
use app\common\api\Base;
/**
 * 用户内部接口
 */
class User extends Base
{   
    // 用户列表
    public function user_list(){
        // 搜索
        $keyword                                  = I('keyword', '', 'string');
        $condition                                = array('like', '%' . $keyword . '%');
        $map['id|username|nickname|email|mobile'] = array(
            $condition,
            $condition,
            $condition,
            $condition,
            $condition,
            '_multi' => true,
        );
        // 获取所有用户
        $map['status'] = array('egt', '0'); // 禁用和正常状态
        $p             = !empty(I('p')) ? I('p') : 1;
        $user_object   = D2('AdminUser');
        $data_list     = $user_object
            ->where($map)
            ->order('id desc')
            ->select();
        return $this->res_good($data_list); 
    }




}
