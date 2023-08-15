<?php

//开发者二次开发公共函数统一写入此文件，不要修改function.php以便于系统升级。

// 调用模块的操作方法 参数格式 [模块/控制器/操作]
function API($name, $method='get_instance', $vars=[]) {
    return A('common/'.$name.'/'.$method, $vars, 'api') ;
}

// 快速取common模块中模型
function D2($name = '', $layer = 'model', $appendSuffix = false) {
    return model('common/'.$name, $layer, $appendSuffix);
}

// 调用模块的操作方法 参数格式 [模块/控制器/操作]
function A2A($name, $method='get_instance', $vars=[]) {
    S('ACCESS',1,10);
    $class = A('home/'.$name.'/'.$method, $vars, 'admin') ;
    S('ACCESS',null);
    return $class;
}


/**
 * 根据配置类型解析配置
 * @param  string $type  配置类型
 * @param  string  $value 配置值
 */
function parse_attr($value, $type = null) {
    switch ($type) {
        default: //解析"1:1\r\n2:3"格式字符串为数组
            $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
            if (strpos($value,':')) {
                $value  = array();
                foreach ($array as $val) {
                    list($k, $v) = explode(':', $val);
                    $value[$k]   = $v;
                }
            } else {
                $value = $array;
            }
            break;
    }
    return $value;
}


/**
 * 根据用户ID获取用户信息
 * @param  integer $id 用户ID
 * @param  string $field
 * @return array  用户信息
 */
function get_user_info($id, $field) {
    $user_onject= D2('AdminUser');
    $userinfo = $user_onject->find($id);
    if (!$field) {
        return $userinfo;
    }
    if ($userinfo[$field]) {
        return $userinfo[$field];
    } else {
        return false;
    }
}


/**
 * 获得模板
 * @param  string $model 模块目录名
 * @param  string $theme 主题名
 */
function get_template_list($model, $theme='') {
    $theme = $theme ? $theme : C('CURRENT_THEME');
    if($theme){
        $template_list = \nfutil\File::get_dirs( APP_PATH . 'cms/template/'.$theme.'/'.$model);
    } else {
        $template_list = \nfutil\File::get_dirs( APP_PATH . 'cms/template/defalut/'.$model);
    }
    return $template_list;
}

function get_template($model, $filename, $theme='') {
    $theme = $theme ? $theme : C('CURRENT_THEME');
    if($theme){
        $template = '../../../cms/template/'.$theme.'/'.$model.'/'.$filename.'.html';
    } else {
        $template = APP_PATH . 'cms/template/defalut/'.$model.'/'.$filename.'.html';
    }
    
    if(is_file($template))
    return $template;
    return '';
}

// 生成键值对组
function make_k_v_array($arr,$k,$v){
    foreach($arr as $vol){
        $new[$vol[$k]] = $vol[$v];
    }
    return $new;
}

function mLog($title,$post){
    $data['title'] = $title;
    $data['content'] = serialize($post);
    $data['date_line'] = date('Y-m-d H:i:s',time());
    $Mobile_Detect = new \Mobile_Detect();
    $data['front'] = $Mobile_Detect->getUserAgent();
    $data['ip'] = get_ip();
    M('cf_log_opt',null)->add($data);
}


//不同环境下获取真实的IP
function get_ip(){
    //判断服务器是否允许$_SERVER
    if(isset($_SERVER)){    
        if(isset($_SERVER[HTTP_X_FORWARDED_FOR])){
            $realip = $_SERVER[HTTP_X_FORWARDED_FOR];
        }elseif(isset($_SERVER[HTTP_CLIENT_IP])) {
            $realip = $_SERVER[HTTP_CLIENT_IP];
        }else{
            $realip = $_SERVER[REMOTE_ADDR];
        }
    }else{
        //不允许就使用getenv获取  
        if(getenv("HTTP_X_FORWARDED_FOR")){
              $realip = getenv( "HTTP_X_FORWARDED_FOR");
        }elseif(getenv("HTTP_CLIENT_IP")) {
              $realip = getenv("HTTP_CLIENT_IP");
        }else{
              $realip = getenv("REMOTE_ADDR");
        }
    }
    return $realip;
}    

// 说明：获取完整URL
function cur_url() 
{
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") 
    $pageURL .= "s";
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") 
    $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    else 
    $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    return $pageURL;
}

// 清除html、css、js格式并去除空格
function cutstr_html($string, $sublen)    
{
    $string = strip_tags($string);
    $string = preg_replace ('/\n/is', '', $string);
    $string = preg_replace ('/ |　/is', '', $string);
    $string = preg_replace ('/&nbsp;/is', '', $string);
    preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $t_string);   
    if(count($t_string[0]) - 0 > $sublen) $string = join('', array_slice($t_string[0], 0, $sublen))."…";   
    else $string = join('', array_slice($t_string[0], 0, $sublen));
    return $string;
}