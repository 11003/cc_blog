<?php

namespace module\core\login;

use biz\Session;
use CRequest;

class CoreLoginLogoutAdminAction extends \CAction
{

    public function execute(CRequest $request)
    {
        Session::logout();
        return new \CRedirectData('');
    }

}