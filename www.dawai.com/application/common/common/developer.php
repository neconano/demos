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

