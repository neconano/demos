<?php
namespace app\common\api;
use app\common\api\Base;
use nfutil\Page;
use think\Loader;

class Home extends Base
{   

    // public function get_products($where=[]) {
    //     $mode = 'NcProduct';
    //     $page_row = 8;
    //     $keyword = I('keyword', '', 'string');
    //     $condition = array('like','%'.$keyword.'%');
    //     $map['id|title'] = array($condition, $condition, $condition,'_multi'=>true);
    //     // $map['status'] = 1;  // 禁用和正常状态
    //     $map = array_merge($map, $where);
    //     $map['is_sale'] = 1;
    //     $data_list = D2($mode)->page(!empty(I('p'))?I('p'):1, $page_row)->where($map)->order('sort desc,id desc')->select();
    //     // 数据处理
    //     $data_list = API('P2p')->_fix_data($data_list);
    //     foreach($data_list as &$v){
    //         $www['product_id'] = $v['id'];
    //         $v['sales'] = $this->get_sale_products($www);
    //     }
    //     return $data_list;
    // }

    // // 获得项目
    // public function get_sale_products($where=[]){
    //     $mode = 'NcSale';
    //     $page_row = 8;
    //     $keyword = I('keyword', '', 'string');
    //     $condition = array('like','%'.$keyword.'%');
    //     $map['id|title'] = array($condition, $condition, $condition,'_multi'=>true);
    //     $map['status'] = 1;  // 禁用和正常状态
    //     if($where['id']){
    //         $map['id'] = $where['id'];
    //     }
    //     $map = array_merge($map, $where);
    //     $data_list = D2($mode)->page(!empty(I('p'))?I('p'):1, $page_row)->where($map)->order('id desc')->select();
    //     // 数据处理
    //     $data_list = API('P2p')->_fix_data($data_list);
    //     // 获得有效项目
    //     foreach($data_list as &$v){
    //         $ww2w['sale_id'] = $v['id'];
    //         $ww2w['status'] = 1;
    //         $list = D2('NcSaleexpriyitem')->where($ww2w)->select();
    //         foreach($list as $v2){
    //             $v['expriy_item'][] = $v2;
    //             $items[] = $v2['title'];
    //         }
    //         $v['expriy_title'] = implode('、',$items);
    //     }
    //     return $data_list;
    // }

    // ===================================================
    // ===================================================
    // ===================================================
    public $deal_status = [0=>'等待确认',-1=>'无效交单',1=>'已支付'];

    // 列表项目
    public function get_project_list($where=[]){
        $res['status'] = true;
        $mode = 'hm_project';
        $page_row = 8;
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title'] = array($condition, $condition, $condition,'_multi'=>true);
        $map = array_merge($map, $where);
        $data_list = D2($mode)->page(!empty(I('p'))?I('p'):1, $page_row)->where($map)->order('sort desc,id desc')->select();
        $data_list = $this->_fix_data($data_list);
        foreach($data_list as &$v){
            $v['label_name'] = explode(',',$v['label']);
            $v['is_reversal_name'] = $v['is_reversal']?'可复投':'仅首投';
            // 获得产品列表
            $ww2w['p_id'] = $v['id'];
            $getRes = $this->get_project_item_list($ww2w);
            $v['item_list'] = $getRes['data'];
            // 获得资质
            $ww4w['p_id'] = $v['id'];
            $getRes = $this->get_project_level_list($ww4w);
            $v['level_list'] = $getRes['data'];
        }
        $page = new Page(D2($mode)->where($map)->count(), $page_row);
        $res['data'] = $data_list;
        $res['page'] = $page;
        return $res;
    }

    // 数据处理
    public function _fix_data($data_list){
        $i=0;
        foreach($data_list as $v){
            $content = unserialize($v['content']);
            unset($content['id']);
            foreach($content as $k2k => $v2v){
                if($v2v){
                    $data_list[$i][$k2k] = $v2v;
                }
            }
            $i++;
        }
        return $data_list;
    }

    // 编辑项目
    public function edit_project($post){    
        $res['status'] = false;
        $mode_object = D2('hm_project');
        $post = I('post.');
        $post['content'] = serialize($post);
        $data = $mode_object->create($post);
        if ($data) {
            if($data['id'])
                $result = $mode_object->save($data);
            else
                $result = $mode_object->add();
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $url = Cookie('__forward_edit_project__')?:U('projects');
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }

    // 项目
    public function get_project($where=[]){
        $res['status'] = true;
        $mode = 'hm_project';
        $data_list = D2($mode)->page(!empty(I('p'))?I('p'):1, $page_row)->where($where)->order('id desc')->select();
        $data_list = $this->_fix_data($data_list);
        $res['data'] = $data_list[0];
        return $res;
    }

    // 产品列表
    public function get_project_item_list($where=[]) {
        $res['status'] = true;
        $mode = 'HmProjectItem';
        $data_list = D2($mode)->where($where)->order('sort desc, id desc')->select();
        $data_list = $this->_fix_data($data_list);
        foreach($data_list as &$v){
            $v['red_bag_name'] = $v['red_bag']?'可用红包':'禁止使用';
            $v['red_bag_style'] = $v['red_bag']?'':'style="color: red !important;"';
            $v['rebate'] = $v['rebate_2']?:$v['rebate_1'].'%';
            $v['rebate_name'] = $v['rebate_2']?'定额返利':'返利比例';
        }
        $res['data'] = $data_list;
        return $res;
    }

    // 项目
    public function get_item($where=[]){
        $res['status'] = true;
        $mode = 'hm_project_item';
        $data_list = D2($mode)->where($where)->order('id desc')->select();
        $data_list = $this->_fix_data($data_list);
        $res['data'] = $data_list[0];
        return $res;
    }

    // 编辑产品
    public function edit_item($post){    
        $res['status'] = false;
        $mode_object = D2('hm_project_item');
        $post = I('post.');
        $post['content'] = serialize($post);
        $data = $mode_object->create($post);
        if ($data) {
            if($data['id'])
                $result = $mode_object->save($data);
            else
                $result = $mode_object->add();
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $url = Cookie('__forward_project_item__')?:U('project_item',['p_id'=>$post['p_id']]);
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }

    // 项目资质
    public function get_project_level_list($where=[]) {
        $res['status'] = true;
        $mode = 'HmProjectLevel';
        $data_list = D2($mode)->where($where)->order('id desc')->select();
        $data_list = $this->_fix_data($data_list);
        $res['data'] = $data_list;
        return $res;
    }

    // 编辑
    public function edit_level($post){    
        $res['status'] = false;
        $mode_object = D2('hm_project_level');
        $post = I('post.');
        $data = $mode_object->create($post);
        if ($data) {
            if($data['id'])
                $result = $mode_object->save($data);
            else
                $result = $mode_object->add();
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $url = Cookie('__forward_project_level__')?:U('project_level',['p_id'=>$post['p_id']]);
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }

    public function get_level($where=[]){
        $res['status'] = true;
        $mode = 'hm_project_level';
        $data_list = D2($mode)->where($where)->order('id desc')->select();
        $data_list = $this->_fix_data($data_list);
        $res['data'] = $data_list[0];
        return $res;
    }

    public function get_rebate_count($where=[]){
        $res['status'] = true;
        $where['deal_status'] = 1;
        $data_list = M('hm_bookin',null)->where($where)->select();
        $data['invest'] = 0;
        $data['rebate'] = 0;
        foreach($data_list as $v){
            $data['invest'] += $v['money'];
            $data['rebate'] += $v['re_money'];
        }
        $data['invest'] = number_format($data['invest']);
        $data['rebate'] = number_format($data['rebate']);
        $res['data'] = $data;
        return $res;
    }
    
    // 列表广告
    public function get_ads_list($where=[]){
        $res['status'] = true;
        $mode = 'hm_ads';
        $page_row = 8;
        $data_list = D2($mode)->page(!empty(I('p'))?I('p'):1, $page_row)->where($where)->order('sort desc,id desc')->select();
        foreach($data_list as &$v){
            $v['page'] = unserialize($v['page']);
            $v['position'] = unserialize($v['position']);
        }
        $page = new Page(D2($mode)->where($where)->count(), $page_row);
        $res['data'] = $data_list;
        $res['page'] = $page;
        return $res;
    }

    // 广告
    public function edit_ads($post){
        $res['status'] = false;
        $mode_object = D2('hm_ads');
        $data = $mode_object->create($post);
        if ($data) {
            $data['page'] = serialize($data['page']);
            $data['position'] = serialize($data['position']);
            if($data['id'])
                $result = $mode_object->save($data);
            else
                $result = $mode_object->add();
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $url = Cookie('__forward_ads__')?:U('ads');
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }

    // 广告
    public function get_ads($where=[]){
        $res['status'] = true;
        $mode = 'hm_ads';
        $data_list = D2($mode)->where($where)->order('sort desc, id desc')->select();
        foreach($data_list as &$v){
            $v['page'] = unserialize($v['page']);
            $v['position'] = unserialize($v['position']);
        }
        $res['data'] = $data_list[0];
        return $res;
    }

    // 前端获得广告
    public function get_home_ads($page,$position){
        if($page == '首页')
            $www['page'] = array('like','%home%');
        if($page == '列表页')
            $www['page'] = array('like','%list%');

        if($position == '上面')
            $www['position'] = array('like','%top%');
        if($position == '中间')
            $www['position'] = array('like','%mid%');
        if($position == '下面')
            $www['position'] = array('like','%bottom%');

        $res['status'] = true;
        $mode = 'hm_ads';
        $data_list = D2($mode)->where($www)->order('sort desc, id desc')->select();
        foreach($data_list as &$v){
            $v['page'] = unserialize($v['page']);
            $v['position'] = unserialize($v['position']);
        }
        $res['data'] = $data_list;
        return $res;
    }

    // 列表公告
    public function get_notice_list($where=[]){
        $res['status'] = true;
        $mode = 'hm_notice';
        $page_row = 8;
        $data_list = D2($mode)->page(!empty(I('p'))?I('p'):1, $page_row)->where($where)->order('sort desc,id desc')->select();
        $page = new Page(D2($mode)->where($where)->count(), $page_row);
        $res['data'] = $data_list;
        $res['page'] = $page;
        return $res;
    }

    // 公告
    public function get_notice($where=[]){
        $res['status'] = true;
        $mode = 'hm_notice';
        $data_list = D2($mode)->where($where)->order('sort desc, id desc')->select();
        $res['data'] = $data_list[0];
        return $res;
    }

    // 公告
    public function edit_notice($post){
        $res['status'] = false;
        $mode_object = D2('hm_notice');
        $data = $mode_object->create($post);
        if ($data) {
            if($data['id'])
                $result = $mode_object->save($data);
            else
                $result = $mode_object->add();
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $url = Cookie('__forward_notice__')?:U('notice');
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }

    // 列表交单
    public function get_bookin_list($where=[]){
        $res['status'] = true;
        $mode = 'hm_bookin';
        $page_row = 8;
        $p = $where['page']?:1;
        if($where['page'])
            unset($where['page']);
        $data_list = D2($mode)->page($p, $page_row)->where($where)->order('id desc')->select();
        $getRes = $this->get_project_list();
        foreach($getRes['data'] as $v){
            $projects[$v['id']] = $v;
        }
        foreach($data_list as &$v){
            $v['deal_status_name'] = $this->deal_status[$v['deal_status']];
            $v['deal_picture'] = get_cover($v['deal_picture']);
            $v['tel_name'] = substr_replace($v['tel'], '****', 3, 4);
            $v['content'] = unserialize($v['content']);
            $item = unserialize($v['content']['content']);
            $v['invest_detail'] = $v['tel'].'/'.$v['name'].'/'.$v['money'].'元';
            $v['alipay_detail'] = $v['alipay_tel'].'/'.$v['alipay_name'];
            $v['re_money_ex'] = $v['item_rebate']?'返利比例：'.$v['item_rebate'].'%':'定额：'.$v['re_money'];
            if($v['project_id'] == 0 && $v['item_id'] == 0){
                $changyoucai = [
                    'title'=>'常有财',
                    'label_name'=>['国资入股'],
                    'rate_year'=> round($v['re_money'] / ($v['money']*30/365) , 3) * 100 ,
                ];
                $v['project_info'] = $changyoucai ;
            }else{
                $dt['title'] = $projects[$v['project_id']]['title'];
                $dt['label_name'] = explode(',', $projects[$v['project_id']]['label']);
                // $dt['rate_year'] = $projects[$v['project_id']][item_list][0]['rate_year'];
                $dt['rate_year'] = $item['rate_year'];
                $v['project_info'] = $dt ;
            }
        }
        $count = D2($mode)->where($where)->count();
        $page = new Page($count, $page_row);
        $res['data'] = $data_list;
        $res['page'] = $page;
        return $res;
    }

    // 防攻击
    public function defense($mode_name,$day_row) {
        $Mobile_Detect = new \Mobile_Detect();
        $www['front'] = $Mobile_Detect->getUserAgent();
        $www['ip'] = get_ip();
        $today2 = date('Y-m-d',time()).' 00:00:00';
        $today3 = date('Y-m-d',time()).' 24:00:00';
        $www['date_line'] = array('exp', ' > "'.$today2.'" and date_line < "'.$today3.'"'  );
        $row = M($mode_name,null)->where($www)->count();
        if($row > $day_row)
        return false;
        return true;
    }

    // 交单
    public function bookin($post) {
        $res['status'] = false;
        // 令牌验证错误
        $validate = Loader::validate('Bookin');
        if(!$validate->check($post)){
            mLogVT('交单|失败：'.$validate->getError(),$post);
            $res['msg'] = '请关闭页面重新提交';
            return $res;
        }
        // 防攻击
        if(!$this->defense('nc_log_sale',8)){
            $res['msg'] = '交单过多，请明天再试';
            mLogVT('交单|失败：'. $res['msg'],$post);
            return $res;
        }
        // 验证有效项目
        $book_in_param = [
            'name'=>'投资人姓名',
            'tel'=>'投资人手机号',
            'item_id'=>'投资产品',
            'money'=>'投资金额',
            'pay_time'=>'投资时间',
            'alipay_tel'=>'支付宝账号',
            'alipay_name'=>'支付宝真实姓名',
        ];
        foreach($book_in_param as $k=>$v){
            if(!$post[$k]){
                mLogVT('交单|失败：缺少项目'.$v,$post);
                $res['msg'] = '请填写'.$v;
                return $res;
            }
        }
        
        $ww1w['id'] = $post['item_id'];
        $ww1w['is_hide'] = 0;
        $getRes = $this->get_item($ww1w);
        if(!$getRes['data']['p_id']){
            mLogVT('交单|失败：异常1',$post);
            $res['msg'] = '发生错误，请联系客服';
            return $res;
        }
        $item = $getRes['data'];
        $ww2w['id'] = $item['p_id'];
        $getRes = $this->get_project($ww2w);
        if(!$getRes['data']['id']){
            mLogVT('交单|失败：异常2',$post);
            $res['msg'] = '发生错误，请联系客服';
            return $res;
        }
        $project = $getRes['data'];
        $data['item_id'] = $item['id'];
        $data['project_id'] = $item['p_id'];
        $data['create_time'] = date('Y-m-d H:i:m',time());
        $data['item_rebate'] = $item['rebate_1'];
        $data['money'] = $post['money'];
        $data['re_money'] = $item['rebate_2']?:$data['item_rebate']*floor($data['money']/100);
        $data['tel'] = $post['tel'];
        $data['name'] = $post['name'];
        $data['alipay_tel'] = $post['alipay_tel'];
        $data['alipay_name'] = $post['alipay_name'];
        $data['item_title'] = '['.$project['title'].']'.$item['title'];
        $data['pay_time'] = $post['pay_time'];
        $data['ext'] = $post['ext'];
        $data['ip'] = $this->request->ip();
		$Mobile_Detect = new \Mobile_Detect();
        $data['front'] = $Mobile_Detect->getUserAgent();
        $data['content'] = serialize($item);
        $id = D2('hm_bookin')->add($data);
        if(!$id){
            mLogVT('交单|失败：异常3',$post);
            $res['msg'] = '发生错误，请稍后再试';
            return $res;
        }
        $this->bookin_ok_notice();
        mLog('交单|完成',$data);
        $res['status'] = true;
        $res['data'] = $data;
        return $res;
    }

    // 交单
    public function edit_bookin($deal_what,$post){
        $res['status'] = false;
        $mode = 'hm_bookin';
        $mode_object = D2($mode);
        if($deal_what == 'fail'){
            $new_post['fail_reason'] = $post['fail_reason'];
            $new_post['remark'] = $post['remark'];
            $new_post['deal_time'] = date('Y-m-d H:i:m',time());
            $new_post['deal_status'] = -1;
        }
        if($deal_what == 'pay'){
            $new_post['deal_picture'] = $post['deal_picture'];
            $new_post['remark'] = $post['remark'];
            $new_post['deal_time'] = date('Y-m-d H:i:m',time());
            $new_post['re_money'] = $post['re_money'];
            $new_post['deal_status'] = 1;
        }
        $new_post['id'] = $post['id'];
        $data = $mode_object->create($new_post);
        if ($data && $data['id']) {
            $result = $mode_object->save($data);
            if ($result !== false) {
                $res['status'] = true;
                $res['msg'] = '成功';
                $url = Cookie('__forward_bookin_fail__')?:U('books');
                $res['url'] = $url;
            }
        } else {
            $res['msg'] = $mode_object->getError();
        }
        return $res;
    }

    // 交单
    public function bookin_ok_notice(){
        $res['status'] = false;
        $to = '308715744@qq.com';
        $name = 'Neco';
        $title = '跟投喵交单'.date('Y-m-d H:i',time());
        $body = 'This is the HTML message body <b>in bold!</b>';
        $getRes = API('Email')->send_mail($to, $name, $title, $body);
        if($getRes === true){
            $res['status'] = true;
            return $res;
        }
        $res['msg'] = $getRes;
        return $res;
    }


}
