<?php
return array(
    'app_init' => array(
        'app\\common\\behavior\\InitModule', //初始化安装的模块行为扩展
        'app\\common\\behavior\\InitHook', //初始化插件钩子行为扩展
        'app\\common\\behavior\\InitConfig', //初始化系统配置行为扩展
    ),
);
