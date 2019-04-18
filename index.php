<?php

/**
 * 打印方法 开发过程中使用
 * @param mixed $var 被打印的数据
 */
function p($var) {
    echo "<pre>" . print_r($var, true) . "</pre>";
}
function dd($var){
    echo "<pre>" . var_dump($var) . "</pre>";die;
}

date_default_timezone_set('Asia/Shanghai');
ini_set('display_errors', true);
error_reporting(E_ALL  ^  E_NOTICE );

include __DIR__.'/../CC2/CC.php';

$app = include __DIR__.'/protected/pre/app.php';

$app->run();