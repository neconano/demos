<?php

// 模块信息配置
return array(
    // 模块信息
    'info'       => array(
        'name'        => 'Sign',
        'title'       => '报名',
        'icon'        => 'fa',
        'icon_color'  => '#3CA6F1',
        'description' => '报名',
        'developer'   => 'Neconano',
        'version'     => '1.0.0',
    ),

    // 系统菜单及权限节点配置
    'admin_menu' => array(
        '10000' => array(
            'pid'   => '0',
            'title' => '报名',
            'icon'  => 'fa fa-pencil',
        ),
        '11000' => array(
            'pid'   => '10000',
            'title' => '报名管理',
            'icon'  => 'fa fa-pencil',
        ),
        '11010' => array(
            'pid'   => '11000',
            'title' => '报名列表',
            'icon'  => 'fa',
            'url'   => 'sign/baoming/index',
        ),

    )



);
