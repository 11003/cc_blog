<?php
/**
 * User: Hermit
 * Date: 2019/1/9
 * Time: 18:24
 */

namespace biz\httpInterceptors;


use biz\Session;
use CInterceptors;
use CNext;
use CRedirectData;
use CRequest;
use CResponseData;

class AdminLoginUserCheckInterceptor implements CInterceptors
{

    /**
     * @param CRequest $request
     *
     * @return CResponseData | CNext
     */
    public function handle(CRequest $request, CNext $next)
    {
        if (Session::isLogin()) {
            if(Session::checkUserStatus()){
                return $next;
            }
            Session::logout();
            return new CRedirectData('/core/login/index');
        }
    }

}