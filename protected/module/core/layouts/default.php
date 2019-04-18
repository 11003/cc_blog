<?php

use CC\util\common\widget\widget\WidgetBuilder;
use module\core\layouts\widget\XjwLayoutsWidget;

$leftnav = 'leftnav.php';

echo WidgetBuilder::build(
    new XjwLayoutsWidget(
        '小步资源',
        $content,
        include $leftnav,
        '',
        [
            'home_url'         => \CC::app()->action->genurl('/core/index/index'),
//            'logo_url'         => \CC::app()->baseUrl.'/public/admin/img/logo.jpg',
            'breadcrumbs'      => $this->getBreadcrumbs(),
            'widget'           => [],
            'left_nav_options' => [
                'has_home_nav' => FALSE,
            ],
            'personage_widget' => [],
            'common_cssJs'     => []
        ]
    )
);