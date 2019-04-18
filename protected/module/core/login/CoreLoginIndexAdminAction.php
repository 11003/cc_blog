<?php

namespace module\core\login;


use biz\Encrypt;
use biz\Session;
use CC\db\base\select\ItemModel;
use CC\util\common\server\Cookie;
use CErrorException;
use CNext;
use CRedirectData;
use CRenderData;
use CRequest;
use CResponseData;

class CoreLoginIndexAdminAction extends \CC\action\module\core\login\CoreLoginIndexAdminAction
{

    private $_staff = null;

    protected function getViewDir()
    {
        return __DIR__;
    }

    protected function doCheck($data, CNext $next)
    {
        return $next;
    }

    public function execute(CRequest $request)
    {
        $rs = $this->handleRemember();
        if($rs instanceof CResponseData){
            return $rs;
        }
        if (Session::isLogin()) {
            return new CRedirectData('index/index', []);
        }
        if ($request->hasPost()){

            $this->_staff = ItemModel::make('staff')->addColumnsCondition([
                'account' => $this->account
            ])->execute();

            if($this->_staff && $this->_staff['password'] == Encrypt::encodeStaffPwd($this->pass)){
                return $this->login();
            }

            throw new CErrorException('账户或密码错误');
        }
        return new CRenderData([], $this->getView(), false,null,$this->getViewDir());
    }

    protected function setLoginSession($user)
    {
        Session::login($this->_staff);
    }

    protected function setLoginCookie($user)
    {
        $time = time() + 7 * 86400;
        Cookie::set('core_login_account_account', $user['account'], $time);
        Cookie::set('core_login_account_name', $user['name'], $time);
        if ($this->remember) {
            Cookie::set('core_login_account_remember', json_encode(array(
                'account' => $this->account,
                'pass' => $this->pass,
                'sign' => $this->signRember($this->company,$this->account, $this->pass),
            )), $time);
        }
    }

    protected function signRember($company,$account, $pass)
    {
        return md5(implode('_I_I_', array($account, $pass)));
    }

    protected function updateLastLoginTime($user)
    {
        //UpdateModel::make('user')->addData(array('last_login_time' => time()), $user['id'])->execute();
    }

}