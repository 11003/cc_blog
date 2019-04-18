<?php
/**
 * User: Hermit
 * Date: 2019/1/9
 * Time: 16:40
 */

namespace module\staff\role\server;


use CC\db\base\select\ListModel;

class RoleServer
{

    public static function getRoleSelectData(){
        $res = ListModel::make('role')
            ->select('id,name')
            ->order('id DESC')
            ->execute();

        $data = [];
        foreach($res as $v){
            $data[$v['id']] = $v['name'];
        }
        return $data;
    }

}