<?php

namespace module\staff\dept\tree;

use CC\db\base\select\ListModel;
use CC\util\db\tree\TreeJsData;

/**
 * User: Tr
 * Date: 2019/1/14
 */

class XjwUserDeptTreeJsData extends TreeJsData
{

    protected function getNameStr()
    {
        return 'name';
    }

    protected function getIdStr()
    {
        return 'id';
    }

    protected function getPidStr()
    {
        return 'dept_id';
    }

    protected function getTable()
    {
        return 'staff';
    }

    protected function isNode($list, $data)
    {
        return $data['is_dept_item']?true:false;
    }

    private function getUserList()
    {
        $list = ListModel::make($this->getTable())
            ->select('id,name,dept_id,0 as is_dept_item')
            ->order('l_key ASC,id DESC')
            ->execute();
        return $list;
    }

    private function getDeptList(){
        $dept_list = ListModel::make('dept')
            ->select('id,name,p_id as dept_id,1 as is_dept_item')
            ->order('l_key ASC')
            ->execute();
        return $dept_list;
    }

    protected function getList()
    {
        $user_list = $this->getUserList();
        if(empty($user_list)){
            return [];
        }

        $dept_list = $this->getDeptList();

        return array_merge($dept_list, $user_list);
    }

}