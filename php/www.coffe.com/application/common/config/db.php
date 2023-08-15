<?php
/**
 * 数据库连接配置文件
 */
use think\Env;

// 获得环境配置
// $mysqlConfig = \neco\Tools\ConfigBag::getConfigByKey('mysql');

// 数据库配置
return array(
    'database' => [
        'type'       => 'mysql', // 数据库类型
        'hostname'   => Env::get("mysql_hostname"), // 服务器地址
        // 'hostname'   => $mysqlConfig['hostname'], // 服务器地址
        'database'   => Env::get("mysql_database"), // 数据库名
        'username'   => Env::get("mysql_username"), // 用户名
        'password'   => Env::get("mysql_password"), // 密码
        'hostport'   => Env::get("mysql_hostport"), // 端口
        'prefix'     => Env::get("mysql_prefix"),   // 数据库表前缀
    ],
    'DB_PREFIX'      => Env::get("mysql_prefix"),   //兼容3.2
    'auth_key'       => Env::get("global_auth_key"),// 系统加密KEY，轻易不要修改此项，否则容易造成用户无法登录，如要修改，务必备份原key
);
