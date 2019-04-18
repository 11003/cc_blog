<?php

use CC\util\common\widget\panel\FormPanel;
use CC\util\common\widget\widget\FormWidget;
use CC\util\common\widget\widget\WidgetBuilder;

echo WidgetBuilder::build(new FormWidget($this, $data, [
    'id' => 'dept_form',
    'inputBuildBeforeHandlers' => [],
    'input_is_read_only'       => FALSE
], 'horizontal'), FormPanel::instance());