<?php
/**
 * User: Hermit
 * Date: 2019/1/10
 * Time: 11:27
 */

namespace module\staff\role;


use biz\auth\Auth;
use CC\action\SaveAction;
use module\staff\role\saveHandler\RoleSaveAfterHandler;

class StaffRoleAltAdminAction extends SaveAction
{

    protected function getBreadcrumbs()
    {
        return [
            [
                'name' => '角色信息',
                'url' => $this->genurl('index')
            ],
            [
                'name' => '编辑角色',
                'url' => $this->genurl('alt',$_GET)
            ],
        ];
    }
    protected function getTable()
    {
        return 'role';
    }

    /**
     * @return string "name,pass"
     */
    protected function getPostNames()
    {
        $str_arr = [];
        foreach($_POST as $k => $v){
            $str_arr[] = $k;
        }

        return implode(',',$str_arr);
    }

    protected function getIsOpenTransaction()
    {
        return true;
    }

    protected function onExecute()
    {
        $role = $this->getDetData();

        return [
            'role' => $role,
            'auth_list' => Auth::getRoleAuth($role['id'])
        ];
    }

    protected function getIsExecSave()
    {
        return FALSE;
    }

    protected function onAfterSave($data)
    {
        return [new RoleSaveAfterHandler()];
    }

}