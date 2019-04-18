<?php
/**
 * User: Hermit
 * Date: 2019/1/9
 * Time: 16:21
 */

namespace module\staff\dept;


use CC\action\SaveAction;
use CC\db\base\select\ItemModel;
use CC\util\common\widget\form\IFormViewBuilder;
use CC\util\common\widget\form\IInput;
use CC\util\common\widget\form\SelectInput;
use CC\util\common\widget\form\TextInput;
use module\staff\dept\saveHandler\DeptSaveAfterHandler;
use module\staff\staff\tree\XjwDeptTreeJsData;

class StaffDeptEditAdminAction extends SaveAction implements IFormViewBuilder
{

    protected $isLayout = FALSE;

    public $parent_id = 0;

    protected function getTable()
    {
        return 'dept';
    }

    /**
     * @return string "name,pass"
     */
    protected function getPostNames()
    {
        return 'name,parent_id';
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
        return [new DeptSaveAfterHandler()];
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
            new TextInput('name', '部门名称',['must'],'width_full'),
            new SelectInput('parent_id','父亲部门',XjwDeptTreeJsData::instance()->getSelectInputData([
                '0' => ''
            ]),['must'],'width_full')
        ];
    }
}