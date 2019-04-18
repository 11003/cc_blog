<?php
/**
 * User: Hermit
 * Date: 2019/1/10
 * Time: 11:25
 */

namespace module\staff\role;


use CC\action\DeleteAction;
use CC\db\base\select\ItemModel;
use CErrorException;

class StaffRoleDelAdminAction extends DeleteAction
{
    protected function getTable()
    {
        return 'role';
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
            'role_id' => $data['id']
        ])->execute();

        if($staff){
            throw new CErrorException('该角色存在员工不可以删除');
        }

        return [];
    }

}