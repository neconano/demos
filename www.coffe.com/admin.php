<?php

/**
 * Content-type设置
 */
header("Content-type: text/html; charset=utf-8");

/**
 * PHP版本检查
 */
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    die('require PHP > 5.4.0 !');
}

/**
 * 定义后台标记
 */
define('MODULE_MARK', 'Admin');

// 默认配置
define('DEFAULT_MODULE', 'Admin');
define('DEFAULT_CONTROLLER', 'Login');
define('DEFAULT_ACTION', 'login');

// 加载框架引导文件
require __DIR__ . '/setting.php';
