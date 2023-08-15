<?php

use neco\Tools\ConfigBag;
use neco\String\Utils;
use think\Env;

require_once APP_DIR . 'common/common/business.php'; //业务函数
require_once APP_DIR . 'common/common/developer.php'; //加载开发者二次开发公共函数库
require_once APP_DIR . 'common/common/extra.php'; //加载兼容公共函数库


// 获得配置信息，并调整协议
function convetHttp2Https($key, $force = false){
    return Utils::convetHttp2Https(ConfigBag::getConfigByKey($key), $force);
}


/**
 * 处理插件钩子
 * @param string $hook   钩子名称
 * @param mixed $params 传入参数
 * @return void
 * 
 */
function hook($hook, $params = array())
{
    $result = \think\Hook::listen($hook, $params);
}

/**
 * 获取插件类的类名
 * @param strng $name 插件名
 * 
 */
function get_addon_class($name)
{
    $class = 'addon\\' . lcfirst($name) . '\\' . ucfirst($name);
    return $class;
}

/**
 * 插件显示内容里生成访问插件的url
 * @param string $url url
 * @param array $param 参数
 * 
 */
function addons_url($url, $param = array())
{
    return D2('AdminAddon')->getAddonUrl($url, $param);
}

/**
 * POST数据提前处理
 * @return array
 * 
 */
function format_data($data = null)
{
    //解析数据类似复选框类型的数组型值
    if (!$data) {
        $data = $_POST;
    }
    $data_object = new \nfutil\Date;
    foreach ($data as $key => $val) {
        if (!is_array($val)) {
            $val = trim($val);
            if ($data_object->checkDatetime($val)) {
                $data[$key] = strtotime($val);
            } else if ($data_object->checkDatetime($val, 'Y-m-d H:i')) {
                $data[$key] = strtotime($val);
            } else if ($data_object->checkDatetime($val, 'Y-m-d')) {
                $data[$key] = strtotime($val);
            } else {
                $data[$key] = $val;
            }
        } else {
            $data[$key] = implode(',', $val);
        }
    }
    return $data;
}

/**
 * 获取所有数据并转换成一维数组
 * $model string 查询模型
 * $map array 查询条件
 * $extra string 额外增加数据
 * $key string 结果数组key
 * $config array Tree参数
 * 
 */
function select_list_as_tree($model, $map = null, $extra = null, $key = 'id', $param = null)
{
    //获取列表
    $con['status'] = array('eq', 1);
    if ($map) {
        $con = array_merge($con, $map);
    }
    $model_object = D($model);
    if (in_array('sort', $model_object->getDbFields())) {
        $list = $model_object->where($con)->order('sort asc, id asc')->select();
    } else {
        $list = $model_object->where($con)->order('id asc')->select();
    }

    //转换成树状列表(非严格模式)
    $tree             = new \nfutil\Tree();
    $_param           = array();
    $_param['title']  = 'title';
    $_param['pk']     = 'id';
    $_param['pid']    = 'pid';
    $_param['root']   = 0;
    $_param['scrict'] = true;
    if ($param) {
        $_param = array_merge($_param, $param);
    }
    $list = $tree->array2tree($list, $_param['title'], $_param['pk'], $_param['pid'], $_param['root'], $_param['scrict']);

    if ($extra) {
        $result[0] = $extra;
    }

    //转换成一维数组
    foreach ($list as $val) {
        $result[$val[$key]] = $val['title_show'];
    }
    return $result;
}

/**
 * 解析文档内容
 * @param string $str 待解析内容
 * @return string
 * 
 */
function parse_content($str)
{
    // 将img标签的src改为lazy-src用户前台图片lazyload加载
    $uls = Env::get("url_uls_domain") ?: '\uploads';
    if ($uls) {
        $tmp = preg_replace('/<img.*?src="(.*?Uploads.*?)"(.*?)>/i', "<img class='lazy lazy-fadein img-responsive' style='display:inline-block;' data-src='" . $uls . "$1'>", $str);
        $tmp = preg_replace('/<img.*?src="(\/.*?)"(.*?)>/i', "<img class='img-responsive' style='display:inline-block;' src='" . $uls . "$1'>", $tmp);
    } else {
        $domain = request()->domain();
        $tmp    = preg_replace('/<img.*?src="(.*?Uploads.*?)"(.*?)>/i', "<img class='lazy lazy-fadein img-responsive' style='display:inline-block;' data-src='" . $domain . "$1'>", $str);
        $tmp    = preg_replace('/<img.*?src="(\/.*?)"(.*?)>/i', "<img class='img-responsive' style='display:inline-block;' src='" . $domain . "$1'>", $tmp);
    }
    return $tmp;
}

/**
 * 字符串截取(中文按2个字符数计算)，支持中文和其他编码
 * @static
 * @access public
 * @param str $str 需要转换的字符串
 * @param str $start 开始位置
 * @param str $length 截取长度
 * @param str $charset 编码格式
 * @param str $suffix 截断显示字符
 * @return str
 */
function cut_str($str, $start, $length, $charset = 'utf-8', $suffix = true)
{
    return \nfutil\Str::cutStr(
        $str, $start, $length, $charset, $suffix
    );
}

/**
 * 过滤标签，输出纯文本
 * @param string $str 文本内容
 * @return string 处理后内容
 * 
 */
function html2text($str)
{
    return \nfutil\Str::html2text($str);
}

/**
 * 友好的时间显示
 * @param int    $sTime 待显示的时间
 * @param string $type  类型. normal | mohu | full | ymd | other
 * @param string $alt   已失效
 * @return string
 * 
 */
function friendly_date($sTime, $type = 'mohu', $alt = 'false')
{
    $date = new \nfutil\Date((int) $sTime);
    return $date->friendlyDate($type, $alt);
}

/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 * 
 */
function time_format($time = null, $format = 'Y-m-d H:i')
{
    $time = $time === null ? time() : intval($time);
    return date($format, $time);
}

/**
 * 系统非常规MD5加密方法
 * @param  string $str 要加密的字符串
 * @return string
 * 
 */
function user_md5($str, $auth_key = '')
{
    if (!$auth_key) {
        $auth_key = C('AUTH_KEY') ?: 'OpenCMF';
    }
    return '' === $str ? '' : md5(sha1($str) . $auth_key);
}

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * 
 */
function is_login()
{
    return D2('AdminUser')->is_login();
}

/**
 * 获取上传文件路径
 * @param  int $id 文件ID
 * @return string
 * 
 */
function get_cover($id = null, $type = null)
{
    return D2('AdminUpload')->getCover($id, $type);
}

/**
 * 是否微信访问
 * @return bool
 * 
 */
function is_weixin()
{
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    } else {
        return false;
    }
}

/**
 * 当前请求的host(不包含端口)
 * @access public
 * @return string
 */
function hostname()
{
    $host = explode(':', $_SERVER['HTTP_HOST']);
    return $host[0];
}

/**
 * 自动生成URL，支持在后台生成前台链接
 * @param string $url URL表达式，格式：'[模块/控制器/操作#锚点@域名]?参数1=值1&参数2=值2...'
 * @param string|array $vars 传入的参数，支持数组和字符串
 * @param string|boolean $suffix 伪静态后缀，默认为true表示获取配置值
 * @param boolean $domain 是否显示域名
 * @return string
 * 
 */
function oc_url($url = '', $vars = '', $suffix = true, $domain = true)
{
    $url = U($url, $vars, $suffix, $domain);
    if (MODULE_MARK === 'Admin') {
        $url_model = D2('AdminConfig')->where(array('name' => 'URL_MODEL'))->getField('value');
        switch ($url_model) {
            case '1':
                $result = strtr($url, array('admin.php?s=' => 'index.php'));
                break;
            case '2':
                $result = strtr($url, array('admin.php?s=/' => ''));
                break;
            case '3':
                $result = strtr($url, array('admin.php' => 'index.php'));
                break;
            default:
                $result = strtr($url, array('admin.php' => 'index.php'));
                break;
        }
        return $result;
    } else {
        return $url;
    }
}


/**
 * 是否手机访问
 * @return bool
 * @author jry <598821125@qq.com>
 */
function is_wap() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA'])) {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

// 检测手机格式
function is_mobile($tel) {
    if(!$tel)
    return false;
    if(!preg_match("/^1[34578]{1}\d{9}$/",$tel))
    return false;
    return true;
}
