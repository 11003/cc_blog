<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 11:47
 */

use CC\util\common\widget\panel\FormPanel;
use CC\util\common\widget\widget\FormWidget;
use CC\util\common\widget\widget\WidgetBuilder;

echo WidgetBuilder::build(new FormWidget($this,$data,[
    'id' => 'help_info'
]),FormPanel::instance());