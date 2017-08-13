<?php
//配置文件
return [

    // 默认控制器名
    'default_controller'     => 'Index',
    // 默认操作名
    'default_action'         => 'index',
    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------

    'template'               => [
        // 模板引擎类型 支持 php think 支持扩展
        'type'         => 'Think',
        // 模板路径
        'view_path'    => '',
        // 模板后缀
        'view_suffix'  => 'html',
        // 模板文件名分隔符
        'view_depr'    => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin'    => '<{',
        // 模板引擎普通标签结束标记
        'tpl_end'      => '}>',
        // 标签库标签开始标记
        'taglib_begin' => '<',
        // 标签库标签结束标记
        'taglib_end'   => '>',
    ],

    'OSA_TEMPLATES' => array(
        'default' => '默认模板',
        'schoolpainting' => '青葱校园',
        'blacktie' => '黑色领结',
        'wintertide' => '冰雪冬季',
    ),
   'ADMIN_TITLE'=>'管理后台',
    'COMPANY_NAME'=>'大天地',
];