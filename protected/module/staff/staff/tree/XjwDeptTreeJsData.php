<?php
/**
 * User: Hermit
 * Date: 2019/1/9
 * Time: 15:33
 */

namespace module\staff\staff\tree;


use CC\db\base\select\ListModel;
use CC\util\db\tree\TreeJsData;

class XjwDeptTreeJsData extends TreeJsData
{

    protected function getTable()
    {
        return 'dept';
    }

    protected function getPidStr()
    {
        return 'p_id';
    }

    protected function isDelete($data)
    {
        return $data['id'] == 0 ? FALSE : TRUE;
    }

    protected function isEdit($data)
    {
        return TRUE;
    }

    protected function getConditions()
    {
        return [];
    }

    protected function getList()
    {
        $list = ListModel::make($this->getTable())
            ->select('id,name,p_id')
            ->addConditions(array_merge($this->getConditions(), $this->conditions))
            ->order('l_key ASC')
            ->execute();

        return $list;
    }

    public function getSelectInputData($data = []){
        $res = $this->getList();
        foreach($res as $v){
            $data[$v['id']] = $v['name'];
        }
        return $data;
    }

}