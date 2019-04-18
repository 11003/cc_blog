<?php
/**
 * User: Hermit
 * Date: 2019/1/28
 * Time: 18:05
 */

namespace module\core\action;


use biz\auth\Auth;
use CC\action\ListAction;

class AdminAction extends ListAction
{

    protected function getAuthStr()
    {
        return '';
    }

    public function beforeAction()
    {

        $auth_str = $this->getAuthStr();
        if($auth_str && !Auth::checkAuth($auth_str)){
            throw new \CErrorException('没有权限访问该页面');
        }
        return parent::beforeAction();
    }

}