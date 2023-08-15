<?php
use think\Env;

$_config = [

    // +----------------------------------------------------------------------
    // | 异常页面的模板
    // +----------------------------------------------------------------------

    // 'http_exception_template'    =>  [
    //     // 定义404错误的重定向页面地址
    //     404 =>  APP_PATH.'home/view/public/404.html',
    //     // 还可以定义其它的HTTP status
    //     401 =>  APP_PATH.'401.html',
    // ],

    // 视图输出字符串内容替换
    'view_replace_str'       => array(
        '__ROOT__'       => __ROOT__,
        '__PUBLIC__'     => Env::get("url_pub_domain"),
        '__CDN_DOMAIN__' => Env::get("url_cdn_domain"), // CDN资源域名

        '__LYUI__'       => Env::get("url_pub_domain") . '/libs/lyui/dist',
        '__ADMIN_IMG__'  => Env::get("url_pub_domain") . '/libs/lyui/admin/img',
        '__ADMIN_CSS__'  => Env::get("url_pub_domain") . '/libs/lyui/admin/css',
        '__ADMIN_JS__'   => Env::get("url_pub_domain") . '/libs/lyui/admin/js',
        '__ADMIN_LIBS__' => Env::get("url_pub_domain") . '/libs/lyui/admin/libs',

        '__HOME_IMG__'   => Env::get("url_pub_domain") . '/nf/home/img',
        '__HOME_CSS__'   => Env::get("url_pub_domain") . '/nf/home/css',
        '__HOME_JS__'    => Env::get("url_pub_domain") . '/nf/home/js',
        '__CUI__'        => Env::get("url_pub_domain") . '/libs/cui',
        '__HOME__'    => '/public/cdn-ready/home',
        '__HOME_PUBLIC__'    => '/public/cdn-ready/home',
        '__BUILDER_DIR__'=> BUILDER_DIR,

    ),
    

];

return $_config;