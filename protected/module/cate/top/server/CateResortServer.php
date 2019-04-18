<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 15:29
 */

namespace module\cate\top\server;


use CC\db\base\select\ListModel;

class CateResortServer
{
    public static function getCateForResortInfo($pid = 0,$level = 0)
    {
        $data = ListModel::make('cate')->order('sort DESC')->execute();
        static $arr = [];
        foreach ($data as $item){
            if($item['pid'] == $pid){
                $item['level'] = $level;
                $arr[] = $item;
                self::getCateForResortInfo($item['id'],$level+1);
            }
        }
        return $arr;
    }
}