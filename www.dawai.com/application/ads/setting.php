<?php

// 模块信息配置
return array(
    // 模块信息
    'info'       => array(
        'name'        => 'Ads',
        'title'       => '广告',
        'icon'        => 'fa',
        'icon_color'  => '#3CA6F1',
        'description' => '广告',
        'developer'   => 'Neconano',
        'version'     => '1.0.0',
    ),

    // 系统菜单及权限节点配置
    'admin_menu' => array(
        '10000' => array(
            'pid'   => '0',
            'title' => '广告',
            'icon'  => 'fa fa-barcode',
        ),
        '11000' => array(
            'pid'   => '10000',
            'title' => '广告管理',
            'icon'  => 'fa fa-barcode',
        ),

        '11010' => array(
            'pid'   => '11000',
            'title' => '轮播管理',
            'icon'  => 'fa',
            'url'   => 'ads/ads/index',
        ),
        '11011' => array(
            'pid'   => '11010',
            'title' => '新增',
            'icon'  => 'fa',
            'url'   => 'ads/ads/add',
        ),
        '11012' => array(
            'pid'   => '11010',
            'title' => '编辑',
            'icon'  => 'fa',
            'url'   => 'ads/ads/edit',
        ),
        '11013' => array(
            'pid'   => '11010',
            'title' => '设置状态',
            'icon'  => 'fa',
            'url'   => 'ads/ads/setStatus',
        ),



        '11020' => array(
            'pid'   => '11000',
            'title' => '直播管理',
            'icon'  => 'fa',
            'url'   => 'ads/zhibo/index',
        ),
        '11021' => array(
            'pid'   => '11020',
            'title' => '新增',
            'icon'  => 'fa',
            'url'   => 'ads/zhibo/add',
        ),
        '11022' => array(
            'pid'   => '11020',
            'title' => '编辑',
            'icon'  => 'fa',
            'url'   => 'ads/zhibo/edit',
        ),
        '11023' => array(
            'pid'   => '11020',
            'title' => '设置状态',
            'icon'  => 'fa',
            'url'   => 'ads/zhibo/setStatus',
        ),



    )



);
