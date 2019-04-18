<?php
/**
 * User: Hermit
 * Date: 2019/1/28
 * Time: 17:34
 */

namespace module\staff\staff\server;


use CC\db\base\select\ItemModel;

class StaffServer
{

    private static $_staff_arr = [];

    public static function getStaffInfoById($id){
        if(!isset(self::$_staff_arr[$id])){
            self::$_staff_arr[$id] = ItemModel::make('staff')
                ->addColumnsCondition([
                    'id' => $id
                ])
                ->execute();
        }
        return self::$_staff_arr[$id];
    }

}