<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 11:14
 */

namespace module\cate;


use biz\auth\Auth;
use module\core\layouts\LeftnavInterfaceAdmin;

class CateLeftnavAdmin implements LeftnavInterfaceAdmin
{

    public function addLeftnav(&$leftnav)
    {
//        if(Auth::checkAuth(Auth::CATE_VIEW)){
            $leftnav[] = [
                'sort_key' => 'top',
                'name' => '栏目管理',
                'icon' => 'icon-2-shop-visitation',
                'sub_nav' => [
                    [
                        'name' => '所有栏目',
                        'url' => '/cate/top/index',
                        'params' => []
                    ]
                ]
            ];
//        }
    }
}