<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 16:40
 */

namespace module\cate\top;


use CC\action\DeleteAction;

class CateTopDelAdminAction extends DeleteAction
{
    protected function getTable()
    {
        return 'cate';
    }

    protected function getIsOpenTransaction()
    {
        return TRUE;
    }
}