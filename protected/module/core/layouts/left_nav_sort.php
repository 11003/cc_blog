<?php

$_sort_arr = [
    'zhifa',
    'dashuju',
    'huanwei',
    'qita',
    'staff'
];

$return_sort_arr = [];
foreach($_sort_arr as $key => $val){
    $return_sort_arr[$val] = $key + 1;
}

return $return_sort_arr;