<?php
/**
 * Created by PhpStorm.
 * User: hooklife
 * Date: 2017/1/12
 * Time: 11:52
 */
return [
    /**
     * 账号基本信息，请从微信公众平台/开放平台获取
     */
    'wechat' => [
        'app_id'  => 'wxe654bdc630a2f94f',         // AppID
        'secret'  => 'ea654fab055b2c312cc2084c2d33108f',     // AppSecret
        'token'   => '',          // Token
        'aes_key' => '',                    // EncodingAESKey，安全模式下请一定要填写！！！
    ],
    /**
     * 日志配置
     *
     * level: 日志级别, 可选为：
     *         debug/info/notice/warning/error/critical/alert/emergency
     * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
     * file：日志文件位置(绝对路径!!!)，要求可写权限
     */
    'log' => [
        'level'      => 'debug',
        'permission' =>  0777,
        'file'       =>  LOG_PATH.'easywechat.log',
    ],
    /**
     * OAuth 配置
     *
     * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
     * callback：OAuth授权完成后的回调页地址
     */
    'oauth' => [
        'scopes'   => ['snsapi_base'],
        'callback' => '/home/index/oauth_callback',
    ],
    /**
     * 微信支付
     */
    'payment' => [
        'merchant_id'        => '1386773102',
        'key'                => 'yihaizhaoyang111111mimaSSSSSSSSS',
        'cert_path'          => getcwd().'/cert/apiclient_cert.pem', // XXX: 绝对路径！！！！
        'key_path'           => getcwd().'/cert/apiclient_key.pem',      // XXX: 绝对路径！！！！
        // 'device_info'     => '013467007045764',
        // 'sub_app_id'      => '',
        // 'sub_merchant_id' => '',
        // ...
    ],
    /**
     * Guzzle 全局设置
     *
     * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
     */
    'guzzle' => [
        'timeout' => 3.0, // 超时时间（秒）
        //'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
    ],
];