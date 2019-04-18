<?php
/**
 * User: Hermit
 * Date: 2019/1/9
 * Time: 16:56
 */

namespace biz;


class Encrypt
{

    private static $_key = 'xjw_h_2019';

    public static function encodeStaffPwd($pwd){
        return md5('x_'.md5($pwd.self::$_key).'_xbcx');
    }

}