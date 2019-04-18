<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 17:15
 */

namespace module\article;


use module\core\layouts\LeftnavInterfaceAdmin;

class ArticleLeftnavAdmin implements LeftnavInterfaceAdmin
{

    public function addLeftnav(&$leftnav)
    {
        $leftnav[] = [
            'sort_key' => 'lists',
            'name' => '文章管理',
            'icon' => 'icon-2-shop-visitation',
            'sub_nav' => [
                [
                    'name' => '文章',
                    'url' => '/article/manage/index',
                    'params' => []
                ]
            ]
        ];
    }
}