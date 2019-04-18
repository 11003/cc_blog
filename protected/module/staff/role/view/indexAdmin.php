<?php

use CC\util\common\widget\panel\ListBodyPanel;
use CC\util\common\widget\panel\ListBtnPanel;
use CC\util\common\widget\panel\ListSearchPanel;
use CC\util\common\widget\panel\ListTablePanel;
use CC\util\common\widget\widget\buttons\ButtonWidget;
use CC\util\common\widget\widget\FilterWidget;
use CC\util\common\widget\widget\ListTableWidget;
use CC\util\common\widget\widget\WidgetBuilder;

echo WidgetBuilder::build(
    new FilterWidget($this),
    ListSearchPanel::instance()
);

echo ListBodyPanel::instance()->start();

    echo WidgetBuilder::build(
        new ButtonWidget('新增', 'alt'),
        ListBtnPanel::instance()
    );

    echo WidgetBuilder::build(
        new ListTableWidget($this, $list, $page),
        ListTablePanel::instance()
    );

echo ListBodyPanel::instance()->end();