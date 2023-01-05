<?php

namespace app\common\controller;

use think\Config;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;
use think\Url;
use think\View as ViewTemplate;

/**
 * 公共控制器
 * 
 */
class Controller extends \think\Controller
{

    // 操作表模型名
    protected $_db_model = '';
    // 用户UID
    public $uid = '';
    public $is_invoke = 0;

    /**
     * 初始化方法
     * @return $this
     * 
     */
    protected function _initialize()
    {
        // builder默认操作表模型名
        $this->_db_model = request()->module() .'_'. request()->controller();
        $this->_db_model = strtolower($this->_db_model);
        // 用户UID
        $this->uid = session('user_auth')['uid']?:is_login();
        if(S('ACCESS'))
            $this->is_invoke = 1;
    }

    /**
     * 模板显示 调用内置的模板引擎显示方法
     * @return void
     */
    protected function display($template = '', $config = [], $tmp1 = null, $tmp2 = null)
    {
        if($this->is_invoke)
            return;
        if (!is_file($template)) {
            $depr = C('template.view_depr');
            if ('' == $template) {
                // 如果模板文件名为空 按照默认规则定位
                $template = request()->controller() . $depr . request()->action();
            } elseif (false === strpos($template, $depr)) {
                // 兼容widos和linux
                if(false === strpos($template, '/'))
                $template = request()->controller() . $depr . $template;
            }
        } else {
            $file = $template;
        }
        if ($template === '/') {
            $template = '';
        }

        $this->assign('meta_keywords', C('WEB_SITE_KEYWORD'));
        $this->assign('meta_description', C('WEB_SITE_DESCRIPTION'));
        $this->assign('_new_message', cookie('_new_message')); // 获取用户未读消息数量
        $this->assign('_user_auth', session('user_auth')); // 用户登录信息
        $this->assign('_page_name', strtolower(request()->module() . '_' . request()->controller() . '_' . request()->action()));

        $this->assign('_admin_public_layout', C('ADMIN_PUBLIC_LAYOUT')); // 页面公共继承模版
        $this->assign('_home_public_layout', C('HOME_PUBLIC_LAYOUT')); // 页面公共继承模版
        $this->assign('_home_wap_public_layout', C('HOME_WAP_PUBLIC_LAYOUT')); // 页面公共继承模版
        
        $this->assign('_user_auth', session('user_auth'));              // 用户登录信息
        $this->assign('_user_nav_main', $_user_nav_main);               // 用户导航信息
        $this->assign('_user_center_side', C('USER_CENTER_SIDE'));      // 用户中心侧边
        $this->assign('_user_login_modal', C('USER_LOGIN_MODAL'));      // 用户登录弹窗

        $this->assign('_listbuilder_layout', $config['_listbuilder_layout'] ?:C('LISTBUILDER_LAYOUT') ); // ListBuilder继承模版
        $this->assign('_formbuilder_layout', $config['_formbuilder_layout'] ?:C('FORMBUILDER_LAYOUT')); // FormBuilder继承模版
        $this->assign('_stylebuilder_layout', C('STYLEBUILDER_LAYOUT'));
        $this->assign('_scriptbuilder_layout', C('SCRIPTBUILDER_LAYOUT'));
        $this->assign('_builder_layout', C('BUILDER_LAYOUT'));
        $this->assign('_builder_layout_ext', APP_PATH . strtolower(request()->module()) . '/view' );
        
        // 导航处理
        if(S('admin_menu_mark') == 'admin_menu')
            $this->_admin_menu();
        if(S('admin_menu_mark') == 'user_nav')
            $this->_user_nav();

        $template = strtolower($template);
        if (request()->isAjax()) {
            // IS_API表示是基于Cordova的需要DOM的APP请求
            $html = '';
            if (C('IS_API') && is_file($this->view->parseTemplate($template))) {
                $html = $this->fetch($template);
            }
            $this->success('数据获取成功', '', array('data' => $this->view->__get(), 'html' => $html));
        } else {
            $output = $this->fetch($template);
            \neco\Tools\CDNMapper::renderOutput($output);
            echo $output;
        }
    }

    // 导航处理
    public function _user_nav(){
        // 获取所有导航
        $menu_list     = API('Module')->getAllMenuUserNav(request()->module());
        $this->assign('_menu_list', $menu_list); // 后台主菜单
        // 获取左侧导航
        if (!config('admin_tabs')) {
            $parent_menu_list = API('Module')->getParentMenu('','','user_nav');
            $this->assign('_parent_menu_list', $parent_menu_list['menu']); // 后台父级菜单
            if($menu_list[$parent_menu_list['title']])
                $current_menu_list = $menu_list[$parent_menu_list['title']];
            else{
                // 设置默认栏目
                $current_menu_list = $menu_list[array_keys($menu_list)[0]];
            }
            $this->assign('_current_menu_list', $current_menu_list); // 后台左侧菜单
        }
    }

    // 导航处理
    public function _admin_menu(){
        // 获取所有导航
        $module_object = D2('AdminModule');
        $menu_list     = $module_object->getAllMenu();
        $this->assign('_menu_list', $menu_list); // 后台主菜单
        // 获取左侧导航
        if (!config('admin_tabs')) {
            $parent_menu_list = $module_object->getParentMenu();
            $this->assign('_parent_menu_list', $parent_menu_list); // 后台父级菜单
            if (isset($parent_menu_list[0]['top'])) {
                $current_menu_list = $menu_list[$parent_menu_list[0]['top']];
            } else {
                $current_menu_list = $menu_list[ucfirst(request()->module())];
            }
            $this->assign('_current_menu_list', $current_menu_list); // 后台左侧菜单
        }
    }

    /**
     * 用户登录检测
     * 
     */
    protected function is_login()
    {
        $uid = is_login();
        if ($uid) {
            return $uid;
        } else {
            if (request()->isAjax()) {
                $this->error('请先登录系统', U('admin/Login/login', '', true, true), array('login' => 1));
            } else {
                redirect(U('admin/Login/login', '', true, true));
            }
        }
    }

    /**
     * 设置一条或者多条数据的状态
     * @param $strict 严格模式要求处理的纪录的uid等于当前登陆用户UID
     * 
     */
    public function setStatus($model = '', $strict = null)
    {
        if ('' == $model) {
            $model = $this->_db_model ? $this->_db_model : request()->controller();
        }

        $ids    = array_unique((array) I('ids/a', 0));
        $status = I('status');
        if (empty($ids)) {
            $this->error('请选择要操作的数据');
        }

        // 获取主键
        $status_model      = D($model);
        $model_primary_key = $status_model->getPk();

        // 获取id
        $ids                     = is_array($ids) ? implode(',', $ids) : $ids;
        $map[$model_primary_key] = array('in', $ids);

        // 严格模式
        if ($strict === null) {
            if (MODULE_MARK === 'Home') {
                $strict = true;
            }
        }
        if ($strict) {
            $map['uid'] = array('eq', $this->is_login());
        }
        
        switch ($status) {
            case 'forbid': // 禁用条目
                $data = array('status' => 0);
                $this->editRow(
                    $model,
                    $data,
                    $map,
                    array('success' => '禁用成功', 'error' => '禁用失败')
                );
                break;
            case 'resume': // 启用条目
                $data = array('status' => 1);
                $map  = array_merge(array('status' => 0), $map);
                $this->editRow(
                    $model,
                    $data,
                    $map,
                    array('success' => '启用成功', 'error' => '启用失败')
                );
                break;
            case 'recycle': // 移动至回收站
                // 查询当前删除的项目是否有子代
                if (in_array('pid', $status_model->getDbFields())) {
                    $count = $status_model->where(array('pid' => array('in', $ids)))->count();
                    if ($count > 0) {
                        $this->error('无法删除，存在子项目！');
                    }
                }

                // 标记删除
                $data['status'] = -1;
                $this->editRow(
                    $model,
                    $data,
                    $map,
                    array('success' => '成功移至回收站', 'error' => '回收失败')
                );
                break;
            case 'restore': // 从回收站还原
                $data = array('status' => 1);
                $map  = array_merge(array('status' => -1), $map);
                $this->editRow(
                    $model,
                    $data,
                    $map,
                    array('success' => '恢复成功', 'error' => '恢复失败')
                );
                break;
            case 'delete': // 删除记录
                // 查询当前删除的项目是否有子代
                // 查询当前删除的项目是否有子代
                if (in_array('pid', $status_model->getDbFields())) {
                    $count = $status_model->where(array('pid' => array('in', $ids)))->count();
                    if ($count > 0) {
                        $this->error('无法删除，存在子项目！');
                    }
                }

                // 删除记录
                $result = $status_model->where($map)->delete();
                if ($result) {
                    $this->success('删除成功，不可恢复！');
                } else {
                    $this->error('删除失败');
                }
                break;
            default:
                $this->error('参数错误');
                break;
        }
    }

    /**
     * 对数据表中的单行或多行记录执行修改 GET参数id为数字或逗号分隔的数字
     * @param string $model 数据模型
     * @param array  $data  修改的数据
     * @param array  $map   查询时的where()方法的参数
     * @param array  $msg   执行正确和错误的消息
     *                       array(
     *                           'success' => '',
     *                           'error'   => '',
     *                           'url'     => '',   // url为跳转页面
     *                           'ajax'    => false //是否ajax(数字则为倒数计时)
     *                       )
     * 
     */
    final protected function editRow($model, $data, $map, $msg)
    {
        $msg = array_merge(
            array(
                'success' => '操作成功！',
                'error'   => '操作失败！',
                'url'     => '',
                'ajax'    => request()->isAjax(),
            ),
            (array) $msg
        );
        $model  = D($model);
        $result = $model->where($map)->save($data);
        if ($result != false) {
            $this->success($msg['success'] . $model->getError(), $msg['url'], $msg['ajax']);
        } else {
            $this->error($msg['error'] . $model->getError(), $msg['url'], $msg['ajax']);
        }
    }

    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param mixed     $msg 提示信息
     * @param string    $url 跳转的URL地址
     * @param mixed     $data 返回的数据
     * @param integer   $wait 跳转等待时间
     * @param array     $header 发送的Header信息
     * @return void
     */
    protected function success($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
    {
        $code = 1;
        if (is_numeric($msg)) {
            $code = $msg;
            $msg  = '';
        }
        if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        } elseif ('' !== $url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : Url::build($url);
        }
        $result = [
            'code'       => $code,
            'status'     => $code,
            'info'       => $msg,
            'msg'        => $msg,
            'data'       => $data,
            'url'        => $url,
            'wait'       => $wait,
            'waitSecond' => $wait,
        ];

        $type = $this->getResponseType();
        if ('html' == strtolower($type)) {
            $result = ViewTemplate::instance(Config::get('template'), Config::get('view_replace_str'))
                ->fetch(Config::get('dispatch_success_tmpl'), $result);
        }
        $response = Response::create($result, $type)->header($header);
        throw new HttpResponseException($response);
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param mixed     $msg 提示信息
     * @param string    $url 跳转的URL地址
     * @param mixed     $data 返回的数据
     * @param integer   $wait 跳转等待时间
     * @param array     $header 发送的Header信息
     * @return void
     */
    protected function error($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
    {
        $code = 0;
        if (is_numeric($msg)) {
            $code = $msg;
            $msg  = '';
        }
        if (is_null($url)) {
            $url = Request::instance()->isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ('' !== $url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : Url::build($url);
        }
        $result = [
            'code'       => $code,
            'status'     => $code,
            'info'       => $msg,
            'msg'        => $msg,
            'data'       => $data,
            'url'        => $url,
            'wait'       => $wait,
            'waitSecond' => $wait,
        ];

        $type = $this->getResponseType();
        if ('html' == strtolower($type)) {
            $result = ViewTemplate::instance(Config::get('template'), Config::get('view_replace_str'))
                ->fetch(Config::get('dispatch_error_tmpl'), $result);
        }
        $response = Response::create($result, $type)->header($header);
        throw new HttpResponseException($response);
    }


    // 标准返回
    public function std_return($res)
    {
        if($res['status']){
            $url = $res['url'] ?: '';
            $this->success($res['msg'], $url);
        }
        $this->error($res['msg']);
    }
 
    /**
    * Ajax方式返回数据到客户端
    * @access protected
    * @param mixed $data 要返回的数据
    * @param String $type AJAX返回数据格式
    * @return void
    */
    protected function ajaxReturn($data,$type='') {
        if(func_num_args()>2) {// 兼容3.0之前用法
        $args      =  func_get_args();
        array_shift($args);
        $info      =  array();
        $info['data']  =  $data;
        $info['info']  =  array_shift($args);
        $info['status'] =  array_shift($args);
        $data      =  $info;
        $type      =  $args?array_shift($args):'';
        }
        if(empty($type)) $type =  C('DEFAULT_AJAX_RETURN');
        if(strtoupper($type)=='JSON') {
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data));
        }elseif(strtoupper($type)=='XML'){
        // 返回xml格式数据
        header('Content-Type:text/xml; charset=utf-8');
        exit(xml_encode($data));
        }elseif(strtoupper($type)=='EVAL'){
        // 返回可执行的js脚本
        header('Content-Type:text/html; charset=utf-8');
        exit($data);
        }else{
        // TODO 增加其它格式
        }
    }




}
