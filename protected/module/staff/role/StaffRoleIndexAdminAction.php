<?php
/**
 * User: Hermit
 * Date: 2019/1/8
 * Time: 19:31
 */

namespace module\staff\role;


use biz\auth\Auth;
use CC\action\listHandler\AdditionDataListBeforeHandler;
use CC\util\common\widget\filter\IFilter;
use CC\util\common\widget\filter\InputFilter;
use CC\util\common\widget\listColumn\ArrayToStrColumnValueSetter;
use CC\util\common\widget\listColumn\Column;
use CC\util\common\widget\listColumn\ITableViewCreator;
use CC\util\common\widget\widget\buttons\ButtonWidget;
use CC\util\common\widget\widget\buttons\OperateButtonWidget;
use Closure;
use module\core\action\AdminAction;

class StaffRoleIndexAdminAction extends AdminAction implements ITableViewCreator
{

    protected function getAuthStr()
    {
        return Auth::ROLE_MANAGE;
    }

    public function getTable()
    {
        return 'role';
    }

    protected function getBreadcrumbs()
    {
        return [
            [
                'name' => '角色信息',
                'url' => $this->genurl('index')
            ]
        ];
    }

    protected function getSearchCondition()
    {
        $name = $this->request->getParams('name',FALSE,'');
        if($name){
            $this->dbCondition->addLikeCondition('name','%'.$name.'%');
        }

        $this->dbCondition->order('t.id ASC');
    }

    protected function onListBefore(&$list)
    {
        return [
            new AdditionDataListBeforeHandler('staff', 'role_id',[
                'users' => [
                    'id'   => 'id',
                    'name' => 'name',
                ]],
                TRUE
            ),
        ];
    }

    /**
     * @return  Column[]
     */
    public function createListColumns(array $list)
    {
        $columns = [
            new Column('角色名称','name'),
            new Column('人员列表','users', new ArrayToStrColumnValueSetter('users','name'))
        ];

        return $columns;
    }

    /**
     * @return IFilter[]
     */
    public function createListFilters()
    {
        return [
            new InputFilter('name', '角色名称', '角色名称'),
        ];
    }

    /**
     * @return  ButtonWidget[] | Closure[] | false
     */
    public function createOperateButtons(array $list)
    {
        $buttons = [
            new ButtonWidget('编辑', 'alt'),
            (new OperateButtonWidget('删除', 'del'))->addClassnames('btn-danger'),
        ];

        return $buttons;
    }


}