<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 11:25
 */

namespace module\cate\top;


use CC\util\common\widget\filter\IFilter;
use CC\util\common\widget\filter\InputFilter;
use CC\util\common\widget\listColumn\Column;
use CC\util\common\widget\listColumn\ITableViewCreator;
use CC\util\common\widget\listColumn\SplitColumnValueSetter;
use CC\util\common\widget\widget\buttons\ButtonWidget;
use CC\util\common\widget\widget\buttons\EditAjaxButtonWidget;
use CC\util\common\widget\widget\buttons\OperateButtonWidget;
use Closure;
use module\core\action\AdminAction;

class CateTopIndexAdminAction extends AdminAction implements ITableViewCreator
{

    public function getTable()
    {
        return 'cate';
    }

    protected function getBreadcrumbs()
    {
        return [
            [
                'name' => '栏目管理',
                'url' => $this->genurl('index')
            ]
        ];
    }

    protected function getSearchCondition()
    {
        $search_key = $this->request->getParams('search_key');
        if($search_key){
            $this->dbCondition->addLikeCondition('cate_name','%'.$search_key.'%');
        }
        $this->dbCondition->order('sort DESC');
    }
    /**
     * @return  Column[]
     */
    public function createListColumns(array $list)
    {
        $columns = [
            new Column('栏目名称','cate_name',new SplitColumnValueSetter('cate_name',15)),
            new Column('栏目类型','type',function($data){
                if($data['type'] == 1){
                    return '文章列表';
                } else {
                    return '单页';
                }
            }),
            new Column('排序','sort',function($data){
                return "<input type='text' value='".$data['sort']."' name='".$data['id']."' class='sort'>";
            }),
        ];
        return $columns;
    }
    protected function onListBefore(&$list)
    {
//        $cateTree = CateResortServer::getCateForResortInfo();
//        foreach ($cateTree as $k=>$v){
//            if($v['pid'] != 0){
//                $lists[$k]['cate_name'] = '|'.str_repeat('-',$v['level']*2).$lists[$k]['cate_name'];
//            }
//        }
    }

    /**
     * @return IFilter[]
     */
    public function createListFilters()
    {
        $input_filter = [];
        $input_filter[] = (new InputFilter('search_key',
            '栏目名称',
            '请输入栏目名称',
            TRUE,['is_need_reset'=>true]))
            ->setResetUrl($this->genurl('index'));
        return $input_filter;
    }

    /**
     * @return  ButtonWidget[] | Closure[] | false
     */
    public function createOperateButtons(array $list)
    {
        $operateButtons = [];
        $operateButtons[] = (new EditAjaxButtonWidget('编辑','alt',[]))->setOptions(['success-after' => 'editAfterSuccess']);
        $operateButtons[] = (new OperateButtonWidget('删除','del'))->addClassnames('btn-danger');
        return $operateButtons;
    }
}