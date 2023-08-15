<?php

// 模块信息配置
return array(
    // 模块信息
    'info'       => array(
        'name'        => 'Course',
        'title'       => '课程',
        'icon'        => 'fa',
        'icon_color'  => '#3CA6F1',
        'description' => '课程',
        'developer'   => 'Neconano',
        'version'     => '1.0.0',
    ),

    // 系统菜单及权限节点配置
    'admin_menu' => array(
        '10000' => array(
            'pid'   => '0',
            'title' => '课程',
            'icon'  => 'fa fa-play-circle-o',
        ),
        '11000' => array(
            'pid'   => '10000',
            'title' => '课程管理',
            'icon'  => 'fa fa-play-circle-o',
        ),
        '11010' => array(
            'pid'   => '11000',
            'title' => '课程列表',
            'icon'  => 'fa',
            'url'   => 'course/lesson/index',
        ),
        '11011' => array(
            'pid'   => '11010',
            'title' => '新增',
            'icon'  => 'fa',
            'url'   => 'course/lesson/add',
        ),
        '11012' => array(
            'pid'   => '11010',
            'title' => '编辑',
            'icon'  => 'fa',
            'url'   => 'course/lesson/edit',
        ),
        '11013' => array(
            'pid'   => '11010',
            'title' => '课程安排',
            'icon'  => 'fa',
            'url'   => 'course/lesson/schedule_manage',
        ),
        '11020' => array(
            'pid'   => '11000',
            'title' => '特色管理',
            'icon'  => 'fa',
            'url'   => 'course/feature/index',
        ),
        '11021' => array(
            'pid'   => '11020',
            'title' => '新增',
            'icon'  => 'fa',
            'url'   => 'course/feature/add',
        ),
        '11022' => array(
            'pid'   => '11020',
            'title' => '编辑',
            'icon'  => 'fa',
            'url'   => 'course/feature/edit',
        ),
        '11023' => array(
            'pid'   => '11020',
            'title' => '设置状态',
            'icon'  => 'fa',
            'url'   => 'course/feature/setStatus',
        ),




        '11030' => array(
            'pid'   => '11000',
            'title' => '教师管理',
            'icon'  => 'fa',
            'url'   => 'course/teacher/index',
        ),
        '11031' => array(
            'pid'   => '11030',
            'title' => '新增',
            'icon'  => 'fa',
            'url'   => 'course/teacher/add',
        ),
        '11032' => array(
            'pid'   => '11030',
            'title' => '编辑',
            'icon'  => 'fa',
            'url'   => 'course/teacher/edit',
        ),
        '11033' => array(
            'pid'   => '11030',
            'title' => '设置状态',
            'icon'  => 'fa',
            'url'   => 'course/teacher/setStatus',
        ),



    )



);
