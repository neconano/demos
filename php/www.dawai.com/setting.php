<?php

// THINKPHP常量
define('THINK_START_TIME', microtime(true));
define('THINK_START_MEM', memory_get_usage());
define('EXT', '.php');
define('DS', DIRECTORY_SEPARATOR);
defined('THINK_PATH') or define('THINK_PATH', __DIR__ . DS . 'vendor/thinkphp' . DS);
define('LIB_PATH', THINK_PATH . 'library' . DS);
define('CORE_PATH', LIB_PATH . 'think' . DS);
define('TRAIT_PATH', LIB_PATH . 'traits' . DS);
defined('APP_PATH') or define('APP_PATH', __DIR__ . '/application/');
defined('ROOT_PATH') or define('ROOT_PATH', dirname(realpath(APP_PATH)) . DS);
defined('EXTEND_PATH') or define('EXTEND_PATH', ROOT_PATH . 'extend' . DS);
defined('VENDOR_PATH') or define('VENDOR_PATH', ROOT_PATH . 'vendor' . DS);
defined('RUNTIME_PATH') or define('RUNTIME_PATH', ROOT_PATH . 'runtime' . DS);
defined('LOG_PATH') or define('LOG_PATH', RUNTIME_PATH . 'log' . DS);
defined('CACHE_PATH') or define('CACHE_PATH', RUNTIME_PATH . 'cache' . DS);
defined('TEMP_PATH') or define('TEMP_PATH', RUNTIME_PATH . 'temp' . DS);
defined('CONF_PATH') or define('CONF_PATH', APP_PATH); // 配置文件目录
defined('CONF_PATH_COMMON') or define('CONF_PATH_COMMON', CONF_PATH . 'common/config/'); // 配置文件目录
defined('CONF_EXT') or define('CONF_EXT', EXT); // 配置文件后缀
defined('ENV_PREFIX') or define('ENV_PREFIX', 'PHP_'); // 环境变量的配置前缀
defined('UPLOADS_PATH') or define('UPLOADS_PATH', __DIR__ . '/uploads/' ); // 上传目录
defined('ADDON_PATH') or define('ADDON_PATH', __DIR__ . '/addon/' ); // 插件目录


// 环境常量
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);
define('IS_WIN', strpos(PHP_OS, 'WIN') !== false);

// 载入Loader类
require CORE_PATH . 'Loader.php';

// 加载环境变量配置文件
if (is_file(ROOT_PATH . '.env')) {
    $env = parse_ini_file(ROOT_PATH . '.env', true);
    foreach ($env as $key => $val) {
        $name = ENV_PREFIX . strtoupper($key);
        if (is_array($val)) {
            foreach ($val as $k => $v) {
                $item = $name . '_' . strtoupper($k);
                putenv("$item=$v");
            }
        } else {
            putenv("$name=$val");
        }
    }
}

// lyf定义
define('APP_DIR', APP_PATH );
define('BUILDER_DIR', APP_PATH . 'common/nfutil/builder/');
// define('BUILDER_DIR', VENDOR_PATH . 'neconano/neco-package/NFUtil/builder/');
define('IS_CGI', (0 === strpos(PHP_SAPI, 'cgi') || false !== strpos(PHP_SAPI, 'fcgi')) ? 1 : 0);
if (!IS_CLI) {
    // 当前文件名
    if (!defined('_PHP_FILE_')) {
        if (IS_CGI) {
            //CGI/FASTCGI模式下
            $_temp = explode('.php', $_SERVER['PHP_SELF']);
            define('_PHP_FILE_', rtrim(str_replace($_SERVER['HTTP_HOST'], '', $_temp[0] . '.php'), '/'));
        } else {
            define('_PHP_FILE_', rtrim($_SERVER['SCRIPT_NAME'], '/'));
        }
    }
    if (!defined('__ROOT__')) {
        $_root = rtrim(dirname(_PHP_FILE_), '/');
        define('__ROOT__', (('/' == $_root || '\\' == $_root) ? '' : $_root));
    }
}

// 注册自动加载
\think\Loader::register();
\think\Loader::addNamespace([
    'nfutil' => APP_PATH . 'common/nfutil/',
    // 'nfutil' => VENDOR_PATH . 'neconano/neco-package/NFUtil/',
    'neco\Tools' => VENDOR_PATH . 'neconano/neco-package/Tools/',
]);


// 加载全局配置属性
if (!is_file(CONF_PATH_COMMON.'properties.php')) {
    echo '缺少配置信息：<br>';
    echo '请执行./vendor/phing/phing/bin/phing -f build.xml';
    exit;
}
$properties_config = include CONF_PATH_COMMON.'properties.php';
// 获得环境配置，为了兼容其它包功能
\neco\Tools\ConfigBag::setConfigs($properties_config);

// 注册错误和异常处理机制
\nfutil\Error::register();

// 加载惯例配置文件
\think\Config::set(include THINK_PATH . 'convention' . EXT);

\think\App::run()->send();
