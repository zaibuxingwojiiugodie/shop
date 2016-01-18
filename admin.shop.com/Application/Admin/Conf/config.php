<?php
//windows
//defined('WEB_URL') or define('WEB_URL','http://www.xluo.com/');
//return array(
//    'TMPL_PARSE_STRING'=>array(
//        '__CSS__'=>WEB_URL.'shop/admin.shop.com/Public/Admin/css',
//        '__JS__'=>WEB_URL.'shop/admin.shop.com/Public/Admin/js',
//        '__IMG__'=>WEB_URL.'shop/admin.shop.com/Public/Admin/images',
//        '__LAYER__'=>WEB_URL.'shop/admin.shop.com/Public/Admin/layer/layer.js',
//        '__UPLOADIFY__'=>WEB_URL.'shop/admin.shop.com/Public/Admin/uploadify',
//        '__TREEGRID__'=>WEB_URL.'shop/admin.shop.com/Public/Admin/treegrid',
//        '__ZTREE__'=>WEB_URL.'shop/admin.shop.com/Public/Admin/zTree',
//        '__BRAND__'=>WEB_URL.'shop/admin.shop.com/Uploads/',
//        '__GOODS__'=>WEB_URL.'shop/admin.shop.com/Uploads/',
//    )
//
//);


//linux环境下
defined('WEB_URL') or define('WEB_URL','http://admin.shop.com/');
return array(
    'TMPL_PARSE_STRING'=>array(
        '__CSS__'=>WEB_URL.'Public/Admin/css',
        '__JS__'=>WEB_URL.'Public/Admin/js',
        '__IMG__'=>WEB_URL.'Public/Admin/images',
        '__LAYER__'=>WEB_URL.'Public/Admin/layer/layer.js',
        '__UPLOADIFY__'=>WEB_URL.'Public/Admin/uploadify',
        '__TREEGRID__'=>WEB_URL.'Public/Admin/treegrid',
        '__ZTREE__'=>WEB_URL.'Public/Admin/zTree',
        '__UEDITOR__'=>WEB_URL.'Public/Admin/ueditor',
//        '__BRAND__'=>WEB_URL.'Uploads/',
//        '__GOODS__'=>WEB_URL.'Uploads/',
        '__BRAND__'=>'http://xluo-brand-logo.b0.upaiyun.com/',//又拍云空间的brandlogo的上传地址
        '__GOODS__'=>'http://xluo-goods-logo.b0.upaiyun.com/',//又拍云空间的brandlogo的上传地址
    )

);