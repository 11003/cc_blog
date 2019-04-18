<?php
/**
 * User: Tr
 * Date: 2019/1/14
 */
namespace module\staff\dept\server;

use module\staff\dept\tree\XjwUserDeptTreeJsData;

class DeptStaffServer{

    public static function getDeptTreeData($is_need_no_data = true){
        if($is_need_no_data){
            $default_data = [[
                'id' => '-1',
                'name' => '无跟进人',
                'nodeId' => '0',
                'is_node' => false,
                'is_add' => false,
                'is_edit' => false,
                'is_delete' => false,
                'is_move_up' => false,
                'is_move_down' => false,
                'is_check' => false,
                'is_radio' => true
            ]];
        }else{
            $default_data = [];
        }

        return XjwUserDeptTreeJsData::instance()->getTreeList($default_data);

    }

}