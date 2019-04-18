<?php
/**
 * User: Hermit
 * Date: 2019/1/9
 * Time: 16:21
 */

namespace module\staff\staff;


use CC\action\SaveAction;
use CC\db\base\select\ItemModel;
use CC\util\common\widget\form\creator\PostNamesCreator;
use CC\util\common\widget\form\EmailInput;
use CC\util\common\widget\form\IFormViewBuilder;
use CC\util\common\widget\form\IInput;
use CC\util\common\widget\form\PasswordInput;
use CC\util\common\widget\form\PhoneInput;
use CC\util\common\widget\form\SelectInput;
use CC\util\common\widget\form\TextInput;
use module\staff\role\server\RoleServer;
use module\staff\staff\saveHandler\StaffSaveAfterHandler;
use module\staff\staff\tree\XjwDeptTreeJsData;

class StaffStaffAltAdminAction extends SaveAction implements IFormViewBuilder
{

    protected $isLayout = FALSE;

    protected function getTable()
    {
        return 'staff';
    }

    /**
     * @return string "name,pass"
     */
    protected function getPostNames()
    {
//        return 'name,account,password,dept_id,role_id,phone,email';
//        return PostNamesCreator::create($this);
    }

    protected function getDetData()
    {
        $id = $this->getId();
        if ($id) {
            return ItemModel::make($this->getTable())->addId($id)->execute();
        }
        return null;
    }

    /**
     * @param $data
     * @return ISaveAfterHandler[];
     */
    protected function onAfterSave($data)
    {
        return [new StaffSaveAfterHandler()];
    }

    protected function onBeforeSave(&$data)
    {
    }
    protected function getIsExecSave()
    {
        return FALSE;
    }


    protected function getIsOpenTransaction()
    {
        return TRUE;
    }

    /**
     * @return  IInput[]
     */
    public function createFormInputs()
    {
        return [
            new TextInput('name', '员工姓名',['must']),
            new TextInput('account', '帐号',['must']),
            new PasswordInput('password', '密码'),
            new SelectInput('dept_id','所属部门',XjwDeptTreeJsData::instance()->getSelectInputData(),['must']),
            new SelectInput('role_id','角色类别',RoleServer::getRoleSelectData(),['must']),
            new PhoneInput('phone', '手机号',['must']),
            new EmailInput('email', '邮箱',['must']),
        ];
    }
}