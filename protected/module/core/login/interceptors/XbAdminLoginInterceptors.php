<?php
/**
 * User: Hermit
 * Date: 2019/1/8
 * Time: 12:28
 */

namespace module\core\login\interceptors;


use biz\Session;
use CC\action\module\common\http\admin\AdminLoginInterceptors;
use CJsonData;
use CNext;
use CRedirectData;
use CRequest;

class XbAdminLoginInterceptors extends AdminLoginInterceptors
{

    private function getNoLoginAction()
    {
        return [
            ['action' => '/core/login/index',]
        ];
    }

    public function handle(CRequest $request, CNext $next)
    {
        if (!$request->url->compareActions($this->getNoLoginAction())) {
            if (!Session::isLogin()) {
                if ($request->isAjax()) {
                    return new CJsonData([
                        'ok' => false,
                        'error' => '当前未登录']);
                } else {
                    return new CRedirectData('/core/login/index');
                }
            }
        }
        return $next;
    }

}