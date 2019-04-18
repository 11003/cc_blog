<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 18:18
 */

use CC\util\common\widget\panel\ListBodyPanel;
use CC\util\common\widget\panel\ListBtnPanel;
use CC\util\common\widget\panel\ListSearchPanel;
use CC\util\common\widget\panel\ListTablePanel;
use CC\util\common\widget\widget\buttons\EditAjaxButtonWidget;
use CC\util\common\widget\widget\FilterWidget;
use CC\util\common\widget\widget\ListTableWidget;
use CC\util\common\widget\widget\WidgetBuilder;

echo WidgetBuilder::build(
    new FilterWidget($this,[
        'is_asyn' => true,
        'action' => $this->genurl(''),
    ]),
    ListSearchPanel::instance()
);


echo ListBodyPanel::instance()->start();


echo WidgetBuilder::build(
    (new EditAjaxButtonWidget('新增', 'alt'))->addClassnames('is_open_from_right'),
    ListBtnPanel::instance()
);


echo WidgetBuilder::build(
    new ListTableWidget($this, $list, $page),
    ListTablePanel::instance()
);

echo ListBodyPanel::instance()->end();