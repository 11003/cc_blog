<?php
/**
 * User: Hermit
 * Date: 2019/1/10
 * Time: 12:01
 */

namespace biz\auth;


use biz\Session;
use CC\action\module\location\models\Staff;
use CC\db\base\select\ItemModel;
use CC\db\base\select\ListModel;
use module\staff\dept\server\DeptStaffServer;
use module\staff\staff\server\StaffServer;

class Auth
{

    const AUTH_RANG_NONE = 0;//无权限
    const AUTH_RANG_ALL = 1;//全部
    const AUTH_RANG_SUB = 2;//下属
    const AUTH_RANG_ME = 3;//自己

    //业务管理
    const BUSINESS_VIEW = 'business_view';
    const CUPBOARD_ADD = 'cupboard_add';
    const CUPBOARD_EDIT = 'cupboard_edit';
    const CUPBOARD_DEL = 'cupboard_del';
    const CUPBOARD_OP_DEVICE = 'cupboard_op_device';

    //栏目管理
    const CATE_VIEW = 'cate_view';
    //人员管理
    const STAFF_MANAGE = 'staff_manage';
    const ROLE_MANAGE = 'role_manage';

    private static $_default_auth = [];
    private static $_sub = [];
    private static $_role_arr = [];

    public static function getStaffAuth($staff_id = 0){
        if(!$staff_id){
            $staff_id = Session::getUserID();
        }
        $staff = ItemModel::make('staff')->addColumnsCondition(['id'=>$staff_id])->execute();

        $auth = self::getRoleAuth($staff['role_id']);
        return $auth;
    }

    public static function getRoleAuth($role_id){
        if(!isset(self::$_role_arr[$role_id])){
            $auth_list = self::$_default_auth;

            if($role_id > 0){
                $list = ListModel::make('role_auth')->addColumnsCondition(array(
                    'role_id' => $role_id
                ))->execute();

                foreach ($list as $item) {
                    $auth_list[$item['auth']] = $item['data'];
                }
            }

            self::$_role_arr[$role_id] = $auth_list;
        }

        return self::$_role_arr[$role_id];
    }

    public static function getSubUidArr($staff_id)
    {

        $staff = StaffServer::getStaffInfoById($staff_id);

        $key = $staff['l_key'].'_'.$staff['r_key'];

        if(!isset(self::$_sub[$key])){
            $r = ListModel::make('staff')
                ->addStrCondition('l_key >= ? and r_key <= ?',array($staff['l_key'],$staff['r_key']))
                ->select('id')
                ->execute();

            $id_arr = array_column($r,'id');

            self::$_sub[$key] = $id_arr;
        }

        return self::$_sub[$key];
    }

    public static function checkAuth($auth_str,$staff_id = 0){
        if(!$staff_id){
            $staff_id = Session::getUserID();
        }
        $staff_info = StaffServer::getStaffInfoById($staff_id);

        $auth_arr = self::getRoleAuth($staff_info['role_id']);
        if(isset($auth_arr[$auth_str]) && $auth_arr[$auth_str] > 0){
            return TRUE;
        }
        return FALSE;
    }

    public static function getAuthRangeUids($auth_str){
        $auth = self::getStaffAuth(Session::getUserID())[$auth_str];

        if($auth==Auth::AUTH_RANG_SUB){
            $uids = implode(',',Auth::getSubUidArr(Session::getUserID()));
        }elseif($auth==Auth::AUTH_RANG_ME){
            $uids = Session::getUserID();
        }
        return $uids;
    }

    public static function getAuthRangeNum($auth_str){
        $auth = self::getStaffAuth(Session::getUserID())[$auth_str];
        return $auth;
    }

}