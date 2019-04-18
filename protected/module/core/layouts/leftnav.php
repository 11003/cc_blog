<?php

use module\core\layouts\LeftnavInterfaceAdmin;

$navs = CC::app()->getManagers('module\core\layouts\LeftnavInterfaceAdmin');
$all_left_nav = [];

foreach ($navs as $nav) {
    /**
     * @var LeftnavInterfaceAdmin $nav
     */
    $nav->addLeftnav($all_left_nav);
}

$left_nav_sort_arr = include 'left_nav_sort.php';

$sort_left_nav = [];
$no_sort_nav = [];
foreach($all_left_nav as $nav){
    $sort_key = isset($nav['sort_key'])?$nav['sort_key']:'';
    if(isset($left_nav_sort_arr[$sort_key]) && $left_nav_sort_arr[$sort_key] > 0){
        $sort_left_nav[$left_nav_sort_arr[$sort_key]] = $nav;
    }else{
        $no_sort_nav[] = $nav;
    }
}

ksort($sort_left_nav);

return array_merge($sort_left_nav,$no_sort_nav);