<?php

use biz\httpInterceptors\AdminLoginUserCheckInterceptor;

$app = CC::createApp(include 'staticconf.php');

$app->addHttpInterceptors('admin',[new AdminLoginUserCheckInterceptor()]);
$app->addHttpInterceptors('api',[new \CParamsInterceptor()]);//参数检测 非法字符串过滤

$confs =  include  __DIR__."/action.php";
foreach ($confs as $conf) {
    foreach ($conf['httpInterceptors'] as $httpInterceptor) {
        $app->addHttpInterceptors($httpInterceptor['group'],[$httpInterceptor['interceptor']]);
    }
    foreach ($conf['actionInterceptors'] as $actionInterceptor) {
        $app->addActionInterceptors($actionInterceptor['group'],[$actionInterceptor]);
    }
}

return $app;