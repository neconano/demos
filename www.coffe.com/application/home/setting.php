<?php

// 模块信息配置
return array(
    // 模块信息
    'info'       => array(
        'name'        => 'Home',
        'title'       => '设备',
        'icon'        => 'fa fa-cog',
        'icon_color'  => '#3CA6F1',
        'description' => '设备管理',
        'developer'   => 'Neconano',
        'version'     => '1.0.0',
    ),

    // 用户后台目录
    'user_nav' => array(
        'admin_menu_1' => array(
            '1010000' => array(
                'pid'   => '0',
                'title' => '设备',
                'icon'  => 'fa fa-user',
            ),

            
            
            '1015000' => array(
                'pid'   => '1010000',
                'title' => '系统信息',
                'icon'  => 'fa fa-rss-square',
            ),
                '1015100' => array(
                    'pid'   => '1015000',
                    'title' => '账号信息',
                    'icon'  => 'fa',
                    'url'   => 'admin/change_password',
                ),
                '1015200' => array(
                    'pid'   => '1015000',
                    'title' => '财务信息',
                    'icon'  => 'fa',
                    'url'   => 'admin/finance_info',
                ),
                '1015210' => array(
                    'pid'   => '1015200',
                    'title' => '打款账户',
                    'icon'  => 'fa',
                    'url'   => 'admin/user_card',
                ),
                '1015220' => array(
                    'pid'   => '1015200',
                    'title' => '提现',
                    'icon'  => 'fa',
                    'url'   => 'admin/cash_out',
                ),
            


            '1014000' => array(
                'pid'   => '1010000',
                'title' => '客户管理',
                'icon'  => 'fa fa-rss-square',
            ),
                '1014100' => array(
                    'pid'   => '1014000',
                    'title' => '客户列表',
                    'icon'  => 'fa',
                    'url'   => 'admin/customer_list',
                ),
                    '1014110' => array(
                        'pid'   => '1014100',
                        'title' => '优惠券列表',
                        'icon'  => 'fa',
                        'url'   => 'admin/coupon_list',
                    ),
                    '1014120' => array(
                        'pid'   => '1014100',
                        'title' => '配送券编辑',
                        'icon'  => 'fa',
                        'url'   => 'admin/push_coupon',
                    ),
    
    
                '1014200' => array(
                    'pid'   => '1014000',
                    'title' => '消费记录',
                    'icon'  => 'fa',
                    'url'   => 'admin/pay_log',
                ),
                // '1014300' => array(
                //     'pid'   => '1014000',
                //     'title' => '优惠券管理',
                //     'icon'  => 'fa',
                //     'url'   => 'admin/coupon_manage',
                // ),
                //     '1014310' => array(
                //         'pid'   => '1014300',
                //         'title' => '优惠券编辑',
                //         'icon'  => 'fa',
                //         'url'   => 'admin/coupon_edit',
                //     ),
    
    

                    '1011000' => array(
                        'pid'   => '1010000',
                        'title' => '设备管理',
                        'icon'  => 'fa fa-rss-square',
                    ),
                    '1011100' => array(
                        'pid'   => '1011000',
                        'title' => '设备列表',
                        'icon'  => 'fa',
                        'url'   => 'admin/device_list',
                    ),
                        '1011110' => array(
                            'pid'   => '1011100',
                            'title' => '通道详情',
                            'icon'  => 'fa',
                            'url'   => 'admin/device_tune_list',
                        ),
                            '1011111' => array(
                                'pid'   => '1011110',
                                'title' => '编辑通道',
                                'icon'  => 'fa',
                                'url'   => 'admin/tune_detail',
                            ),
                        '1011120' => array(
                            'pid'   => '1011100',
                            'title' => '设备详情',
                            'icon'  => 'fa',
                            'url'   => 'admin/device_detail',
                        ),
                        // '1011130' => array(
                        //     'pid'   => '1011100',
                        //     'title' => '广告管理',
                        //     'icon'  => 'fa',
                        //     'url'   => 'admin/advertise_list_device',
                        // ),
                        //     '1011131' => array(
                        //         'pid'   => '1011130',
                        //         'title' => '编辑设备广告',
                        //         'icon'  => 'fa',
                        //         'url'   => 'admin/advertise_edit_device',
                        //     ),
                        '1011140' => array(
                            'pid'   => '1011100',
                            'title' => '二维码',
                            'icon'  => 'fa',
                            'url'   => 'admin/make_qrcode',
                        ),
                        '1011150' => array(
                            'pid'   => '1011100',
                            'title' => '兑换码',
                            'icon'  => 'fa',
                            'url'   => 'admin/free_code_list',
                        ),
                            '1011151' => array(
                                'pid'   => '1011150',
                                'title' => '编辑兑换码',
                                'icon'  => 'fa',
                                'url'   => 'admin/make_free_code',
                            ),
                        '1011160' => array(
                            'pid'   => '1011100',
                            'title' => '批量兑换码',
                            'icon'  => 'fa',
                            'url'   => 'admin/push_free_code',
                        ),
                            
            
            
            
            
                    '1011200' => array(
                        'pid'   => '1011000',
                        'title' => '统计数据',
                        'icon'  => 'fa',
                        'url'   => 'admin/data_list',
                    ),
                    '1011300' => array(
                        'pid'   => '1011000',
                        'title' => '故障列表',
                        'icon'  => 'fa',
                        'url'   => 'admin/device_trouble_list',
                    ),






            
        ),

    ),







    // 系统菜单及权限节点配置
    'admin_menu' => array(
        '1010000' => array(
            'pid'   => '0',
            'title' => '设备',
            'icon'  => 'fa fa-user',
        ),

        
        '1014000' => array(
            'pid'   => '1010000',
            'title' => '客户管理',
            'icon'  => 'fa fa-rss-square',
        ),
            '1014100' => array(
                'pid'   => '1014000',
                'title' => '客户列表',
                'icon'  => 'fa',
                'url'   => 'home/Index/customer_list',
            ),
                '1014110' => array(
                    'pid'   => '1014100',
                    'title' => '优惠券列表',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/coupon_list',
                ),
                '1014120' => array(
                    'pid'   => '1014100',
                    'title' => '配送券编辑',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/push_coupon',
                ),


            '1014200' => array(
                'pid'   => '1014000',
                'title' => '消费记录',
                'icon'  => 'fa',
                'url'   => 'home/Index/pay_log',
            ),
            '1014300' => array(
                'pid'   => '1014000',
                'title' => '优惠券管理',
                'icon'  => 'fa',
                'url'   => 'home/Index/coupon_manage',
            ),
                '1014310' => array(
                    'pid'   => '1014300',
                    'title' => '优惠券编辑',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/coupon_edit',
                ),

            
        '1015000' => array(
            'pid'   => '1010000',
            'title' => '分销管理',
            'icon'  => 'fa fa-rss-square',
        ),
        '1015100' => array(
            'pid'   => '1015000',
            'title' => '商户列表',
            'icon'  => 'fa',
            'url'   => 'home/Index/user_list',
        ),
            '1015110' => array(
                'pid'   => '1015100',
                'title' => '银行卡信息',
                'icon'  => 'fa',
                'url'   => 'home/Index/user_card',
            ),
            '1015120' => array(
                'pid'   => '1015100',
                'title' => '账目列表',
                'icon'  => 'fa',
                'url'   => 'home/Index/user_money_record',
            ),
                '1015121' => array(
                    'pid'   => '1015120',
                    'title' => '账目调整',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/user_money_record_edit',
                ),
            '1015130' => array(
                'pid'   => '1015100',
                'title' => '打款',
                'icon'  => 'fa',
                'url'   => 'home/Index/user_pay',
            ),
            '1015140' => array(
                'pid'   => '1015100',
                'title' => '设置',
                'icon'  => 'fa',
                'url'   => 'home/Index/user_pay_set',
            ),
        '1016000' => array(
            'pid'   => '1015000',
            'title' => '提现管理',
            'icon'  => 'fa',
            'url'   => 'home/Index/cash_out_manager',
        ),




        '1011000' => array(
            'pid'   => '1010000',
            'title' => '设备管理',
            'icon'  => 'fa fa-rss-square',
        ),

            '1011400' => array(
                'pid'   => '1011000',
                'title' => '场所管理',
                'icon'  => 'fa',
                'url'   => 'home/Index/shop_list',
            ),
                '1011410' => array(
                    'pid'   => '1011400',
                    'title' => '广告管理',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/advertise_list_shop',
                ),
                    '1011411' => array(
                        'pid'   => '1011410',
                        'title' => '广告编辑',
                        'icon'  => 'fa',
                        'url'   => 'home/Index/advertise_edit_shop',
                    ),


            '1011100' => array(
                'pid'   => '1011000',
                'title' => '设备列表',
                'icon'  => 'fa',
                'url'   => 'home/Index/device_list',
            ),
                '1011110' => array(
                    'pid'   => '1011100',
                    'title' => '通道详情',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/device_tune_list',
                ),
                    '1011111' => array(
                        'pid'   => '1011110',
                        'title' => '编辑通道',
                        'icon'  => 'fa',
                        'url'   => 'home/Index/tune_detail',
                    ),
                '1011120' => array(
                    'pid'   => '1011100',
                    'title' => '设备详情',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/device_detail',
                ),
                '1011130' => array(
                    'pid'   => '1011100',
                    'title' => '广告管理',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/advertise_list_device',
                ),
                    '1011131' => array(
                        'pid'   => '1011130',
                        'title' => '编辑设备广告',
                        'icon'  => 'fa',
                        'url'   => 'home/Index/advertise_edit_device',
                    ),

                '1011180' => array(
                    'pid'   => '1011100',
                    'title' => '分享',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/weixin_share',
                ),

                '1011140' => array(
                    'pid'   => '1011100',
                    'title' => '二维码',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/make_qrcode',
                ),
                '1011150' => array(
                    'pid'   => '1011100',
                    'title' => '兑换码',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/free_code_list',
                ),
                    '1011151' => array(
                        'pid'   => '1011150',
                        'title' => '编辑兑换码',
                        'icon'  => 'fa',
                        'url'   => 'home/Index/make_free_code',
                    ),
                '1011160' => array(
                    'pid'   => '1011100',
                    'title' => '批量兑换码',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/push_free_code',
                ),
                '1011170' => array(
                    'pid'   => '1011100',
                    'title' => '分配',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/push_device2user',
                ),

            '1011200' => array(
                'pid'   => '1011000',
                'title' => '统计数据',
                'icon'  => 'fa',
                'url'   => 'home/Index/data_list',
            ),
            '1011300' => array(
                'pid'   => '1011000',
                'title' => '故障列表',
                'icon'  => 'fa',
                'url'   => 'home/Index/device_trouble_list',
            ),

        '1012000' => array(
            'pid'   => '1010000',
            'title' => '广告管理',
            'icon'  => 'fa fa-rss-square',
        ),
            '1012100' => array(
                'pid'   => '1012000',
                'title' => '设备广告上传',
                'icon'  => 'fa',
                'url'   => 'home/Index/advertise_list_dev',
            ),
                '1012110' => array(
                    'pid'   => '1012100',
                    'title' => '广告详情',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/advertise_detail_dev',
                ),
            '1012200' => array(
                'pid'   => '1012000',
                'title' => '其他广告上传',
                'icon'  => 'fa',
                'url'   => 'home/Index/advertise_list_wx',
            ),
                '1012210' => array(
                    'pid'   => '1012200',
                    'title' => '广告详情',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/advertise_detail_wx',
                ),
            '1012300' => array(
                'pid'   => '1012000',
                'title' => '分享模板',
                'icon'  => 'fa',
                'url'   => 'home/Index/share_template',
            ),
                '1012310' => array(
                    'pid'   => '1012300',
                    'title' => '模板编辑',
                    'icon'  => 'fa',
                    'url'   => 'home/Index/share_template_edit',
                ),


        '1013000' => array(
            'pid'   => '1010000',
            'title' => '其他',
            'icon'  => 'fa fa-rss-square',
        ),

            '1013200' => array(
                'pid'   => '1013000',
                'title' => '省管理',
                'icon'  => 'fa',
                'url'   => 'home/Index/old_os',
            ),
            '1013300' => array(
                'pid'   => '1013000',
                'title' => '市管理',
                'icon'  => 'fa',
                'url'   => 'home/Index/old_os',
            ),
            '1013400' => array(
                'pid'   => '1013000',
                'title' => '升级管理',
                'icon'  => 'fa',
                'url'   => 'home/Index/old_os',
            ),
            '1013500' => array(
                'pid'   => '1013000',
                'title' => '消息管理',
                'icon'  => 'fa',
                'url'   => 'home/Index/old_os',
            ),
        


    )


    


);
