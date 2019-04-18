<?php

namespace module\staff;


use biz\auth\Auth;
use module\core\layouts\LeftnavInterfaceAdmin;

class StaffLeftnavAdmin implements LeftnavInterfaceAdmin
{

    public function addLeftnav(&$leftnav)
    {
        $sub_nav = [];

        if(Auth::checkAuth(Auth::STAFF_MANAGE)){
            $sub_nav[] = [
                'name' => '员工管理',
                'url' => '/staff/staff/index',
                'params' => []
            ];
        }

        if(Auth::checkAuth(Auth::ROLE_MANAGE)){
            $sub_nav[] = [
                'name' => '角色管理',
                'url' => '/staff/role/index',
                'params' => []
            ];
        }

        $leftnav[] = [
            'sort_key' => 'staff',
            'name' => '人员管理',
            'icon' => 'icon-2-account',
            'sub_nav' => $sub_nav
        ];
    }


}