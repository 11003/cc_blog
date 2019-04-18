<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 18:17
 */

namespace module\article\manage;


use CC\util\common\widget\filter\InputFilter;
use CC\util\common\widget\listColumn\Column;
use CC\util\common\widget\listColumn\ITableViewCreator;
use CC\util\common\widget\listColumn\PicColumnValueSetter;
use CC\util\common\widget\listColumn\SplitColumnValueSetter;
use CC\util\common\widget\listColumn\TimeColumnValueSetter;
use CC\util\common\widget\widget\buttons\EditAjaxButtonWidget;
use CC\util\common\widget\widget\buttons\OperateButtonWidget;
use module\core\action\AdminAction;

class ArticleManageIndexAdminAction extends AdminAction implements ITableViewCreator
{

    public function getTable()
    {
        return 'article';
    }

    protected function getBreadcrumbs()
    {
        return [
            [
                'name' => '文章管理',
                'url' => $this->genurl('index')
            ]
        ];
    }

    protected function getSearchCondition()
    {
        $name = $this->request->getParams('name',false,'');
        if($name){
            $this->dbCondition->addLikeCondition('name','%'.$name.'%');
        }
        $this->dbCondition->order('id desc');
    }

    /**
     * @return  Column[]
     */
    public function createListColumns(array $list)
    {
        $columns = [
            new Column('文章名称','name',new SplitColumnValueSetter('name',15)),
            new Column('所属栏目','cid'),
            new Column('图片', 'pic',
                (new PicColumnValueSetter('pic',0,'',['data_type' => 2,'is_show_one' => true]))
                    ->setIsNeedAliossSign(FALSE)
            ),
            new Column('内容','content',new SplitColumnValueSetter('content',50)),
            new Column('更新时间','update_time',new TimeColumnValueSetter('update_time','Y-m-d'))

        ];
        return $columns;
    }

    /**
     * @return IFilter[]
     */
    public function createListFilters()
    {
        $filters[] = (new InputFilter('name',
            '搜索',
            '请输入文章名称',
            TRUE, ['is_need_reset'=>true]))
            ->setResetUrl('index');
        return $filters;

    }

    /**
     * @return  ButtonWidget[] | Closure[] | false
     */
    public function createOperateButtons(array $list)
    {
        $buttons = [];
        $buttons[] = (new EditAjaxButtonWidget('编辑', 'alt'))->addClassnames('is_open_from_right');
        $buttons[] = (new OperateButtonWidget('删除', 'del'))->addClassnames('btn-danger');

        return $buttons;
    }
}