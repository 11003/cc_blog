<?php

namespace biz;
use CC\db\base\select\ItemModel;
use CC\util\common\server\SessionAbs;
use CUserSession;

class Session extends SessionAbs {

    /**
     * @param array $info
     */
    public static function login($info = array())
    {
        if(!empty($info)){
            CUserSession::login(array());
            self::setUserID($info['id']);
            self::setName($info['name']);
        }
    }

    private static $_staff = null;

    public static function getUserInfo(){
        if(self::$_staff === null){
            self::$_staff = ItemModel::make('staff')->addColumnsCondition([
                        'id' => self::getUserID()
                    ])->execute();
        }
        return self::$_staff;
    }

    public static function checkUserStatus(){
        $staff = self::getUserInfo();
        if($staff){
            return TRUE;
        }
        return FALSE;
    }
    public static function webIsLogin($pwd){
        if(self::wxGetData($pwd)){
            return TRUE;
        }
        return FALSE;
    }

    public static function webLogin($pwd){
        self::wxSetData($pwd,1);
    }

    private static function wxSetData($key,$val){
        self::set('web_xbcx'.$key, $val);
    }

    private static function wxGetData($key){
        return self::get('web_xbcx'.$key);
    }

}