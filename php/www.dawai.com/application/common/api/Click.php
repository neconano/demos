<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2017/8/22
 * Time: 15:21
 */

namespace app\common\api;


use think\Db;

class Click extends Base
{
    /**
     * 新增分类点击量
     * @param $category  分类名称
     * @param $data_id   分类数据id
     * @param $ip        ip地址
     */
    public function  click_num($data_id,$category,$ip)
    {
        $where=[
            'category'=>$category,
            'ip'=>$ip,
            'data_id'=>$data_id,
        ];
        $click_id=Db::table('dw_click_counter')->where($where)->order('id desc')->find();
        //点击量
        if (is_null($click_id)||$click_id['create_time']+3600<time()){
            $click_data=[
                'category'=>$category,
                'data_id'=>$data_id,
                'create_time'=>time(),
                'ip'=>$ip,
            ];
            Db::table('dw_click_counter')->insert($click_data);
        }
    }

    /***
     * 获取点击量
     * @param $data_id     分类数据id
     * @param $category    分类名称
     * @return mixed
     */
    public function get_click_num($data_id,$category)
    {
        if (S("'click_num'.$data_id")){
            return S("'click_num'.$data_id");
        }else{
            $where=[
                'category'=>$category,
                'data_id'=>$data_id,
            ];
            $click_num=Db::table('dw_click_counter')->where($where)->count();
            S("'click_num'.$data_id",$click_num,3600*5);
            return S("'click_num'.$data_id");
//            return $click_num;
        }
    }
}