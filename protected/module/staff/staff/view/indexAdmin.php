<?php

use CC\util\common\widget\panel\ListBodyPanel;
use CC\util\common\widget\panel\ListBtnPanel;
use CC\util\common\widget\panel\ListSearchPanel;
use CC\util\common\widget\panel\ListTablePanel;
use CC\util\common\widget\widget\buttons\EditAjaxButtonWidget;
use CC\util\common\widget\widget\FilterWidget;
use CC\util\common\widget\widget\ListTableWidget;
use CC\util\common\widget\widget\TreeWidget;
use CC\util\common\widget\widget\WidgetBuilder;
use module\staff\staff\tree\XjwDeptTreeJsData;

?>

<style type="text/css">
    .user_dept {position: relative;}
    .dept_list {
        width: 200px;
        float: left;
        background-color: white;
        border: 1px solid #e2e2e2;
        min-height: 200px;
    }
    .dept_title{
        height: 40px;
        background-color: #F2F2F2;
        text-align: center;
        line-height: 40px;
        position: relative;
    }
    #add_dept{
        position: absolute;
        right: 10px;
    }
    .user_list {
        margin-left: 212px;
    }
    .user_level_label_1,.user_level_label_2 {font-size: 12px;display: inline-block; border-radius:3px;color: #fff; background-color: #846bb3; padding:2px 5px; }
    .user_level_label_2 {color: #fff; background-color: #ff695d; }
</style>

<?php

echo WidgetBuilder::build(
    new FilterWidget($this,['is_asyn'=>true]),
    ListSearchPanel::instance()
);

?>

<?php echo ListBodyPanel::instance()->start(); ?>

<?php

echo WidgetBuilder::build(
    (new EditAjaxButtonWidget('新增', 'alt', [
        'btn_ok_name'  => '提交',
    ]))->addClassnames('is_open_from_right'),
    ListBtnPanel::instance()
);

?>
<div class="user_dept">
    <div class="dept_list">
        <?php
        echo WidgetBuilder::build(
            new TreeWidget(
                XjwDeptTreeJsData::instance()->getTreeList([
                    [
                        'id' => 0,
                        'name' => '组织结构',
                        'nodeId' => '-1',
                        'is_node' => TRUE,
                        'is_add' => TRUE,
                        'is_edit' => FALSE,
                        'is_delete' => FALSE,
                        'is_move_up' => FALSE,
                        'is_move_down' => FALSE,
                        'is_check' => TRUE
                    ]
                ]),
                [
                    'editable'   => TRUE, //可编辑
                    'edit_url'   => $this->genurl('dept/edit'),
                    'delete_url' => $this->genurl('dept/del'),
                    'move_url'   => $this->genurl('basic/dept/exchange'),
                    'name'       => '部门',
                ]
            )
        );
        ?>
    </div>
        <div class="user_list">
        <?php

        echo WidgetBuilder::build(
            new ListTableWidget($this, $list, $page),
            ListTablePanel::instance()
        );

        ?>
    </div>
</div>

<?php echo ListBodyPanel::instance()->end(); ?>

<script>
    $('#add_dept').click(function(){

    });
</script>