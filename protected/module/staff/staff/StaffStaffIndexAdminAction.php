<?php
/**
 * User: Hermit
 * Date: 2019/1/8
 * Time: 19:31
 */

namespace module\staff\staff;


use biz\auth\Auth;
use CC\action\listHandler\AdditionDataListBeforeHandler;
use CC\util\common\widget\filter\IFilter;
use CC\util\common\widget\filter\InputFilter;
use CC\util\common\widget\form\creator\PostNamesCreator;
use CC\util\common\widget\listColumn\Column;
use CC\util\common\widget\listColumn\ITableViewCreator;
use CC\util\common\widget\widget\buttons\ButtonWidget;
use CC\util\common\widget\widget\buttons\EditAjaxButtonWidget;
use CC\util\common\widget\widget\buttons\OperateButtonWidget;
use Closure;
use CRedirectData;
use module\core\action\AdminAction;

class StaffStaffIndexAdminAction extends AdminAction implements ITableViewCreator
{

//    protected function getAuthStr()
//    {
//        return Auth::STAFF_MANAGE;
//    }

    public function getTable()
    {
        return 'staff';
    }

    protected function getBreadcrumbs()
    {
        return [
            [
                'name' => '人员信息',
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

        $dept_id = (int)$this->request->getParams('dept_id',FALSE,0);
        if($dept_id){
            $this->dbCondition->addColumnsCondition([
                'dept_id' => $dept_id
            ]);
        }

        $this->dbCondition->order('t.l_key ASC,t.id ASC');
    }

    protected function onListBefore(&$list)
    {
        return [
            new AdditionDataListBeforeHandler('dept', 'dept_id', ['dept_name' => 'name']),
            new AdditionDataListBeforeHandler('role', 'role_id', ['role_name' => 'name']),
        ];
    }

    /**
     * @return  Column[]
     */
    public function createListColumns(array $list)
    {
        $columns = [
            new Column('姓名','name'),
            new Column('帐号','account'),
            new Column('角色','role_name'),
            new Column('部门','dept_name'),
            new Column('手机号','phone'),
            new Column('邮箱','email'),
        ];

        return $columns;
    }

    /**
     * @return IFilter[]
     */
    public function createListFilters()
    {
        return [
            new InputFilter('name', '姓名', '请输入姓名'),
        ];
    }


    /**
     * @return  ButtonWidget[] | Closure[] | false
     */
    public function createOperateButtons(array $list)
    {
        $buttons = [];

        $buttons[] = (new EditAjaxButtonWidget('编辑', 'alt', [
            'btn_ok_name'  => '提交',
        ]))->addClassnames('is_open_from_right');

        $buttons[] = (new OperateButtonWidget('删除', 'del'))->addClassnames('btn-danger');

        return $buttons;
    }



}