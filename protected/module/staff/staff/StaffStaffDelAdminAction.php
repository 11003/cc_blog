<?php
/**
 * User: Hermit
 * Date: 2019/1/9
 * Time: 17:21
 */

namespace module\staff\staff;


use CC\action\DeleteAction;

class StaffStaffDelAdminAction extends DeleteAction
{
    protected function getTable()
    {
        return 'staff';
    }

    protected function getIsOpenTransaction()
    {
        return TRUE;
    }
}