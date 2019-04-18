<?php
/**
 * User: Hermit
 * Date: 2019/1/9
 * Time: 17:21
 */

namespace module\staff\dept;


use CC\action\DeleteAction;
use CC\db\base\select\ItemModel;
use CErrorException;

class StaffDeptDelAdminAction extends DeleteAction
{
    protected function getTable()
    {
        return 'dept';
    }

    protected function getIsOpenTransaction()
    {
        return TRUE;
    }

    /**
     * @param $data
     * @return IDeleteBeforeHandler[]
     */
    protected function onBeforeDelete(&$data)
    {

        $staff = ItemModel::make('staff')->addColumnsCondition([
            'dept_id' => $data['id']
        ])->execute();

        if($staff){
            throw new CErrorException('该部门存在员工不可以删除');
        }

        return [];
    }

}