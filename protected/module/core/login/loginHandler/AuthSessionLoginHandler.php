<?php
/**
 * User: Hermit
 * Date: 2017/6/30
 * Time: 14:47
 */

namespace module\core\login\loginHandler;

use biz\Session;
use CC\action\module\core\login\loginHandler\ILoginChecker;
use CC\db\base\update\UpdateModel;
use CC\util\db\enum\UserClassifyEnum;
use CErrorException;
use IM;

class AuthSessionLoginHandler implements ILoginChecker
{

    /**
     * @param $user
     * @param array $params
     * @throws CErrorException
     */
    public function onLoginCheck($user, $params)
    {
        if(!$user){
            throw new CErrorException('用户账号不存在',500);
        }

        if($user['status'] == 2){
            throw new CErrorException('用户被禁用,请联系管理员',500);
        }

        if($user['status'] == 3){
            throw new CErrorException('该公司正在进行数据转移请耐心等待',500);
        }

        if($user['user_classify'] == UserClassifyEnum::ADMIN){
            $data = \WqInterface::instance()->getUserModules($user['id'],$user['com_id'],1);
        }else{
            $data = \WqInterface::instance()->getUserModules($user['id'],$user['com_id'],0,$user['soft_version']);
        }

        $user_models = isset($data['funs'])?$data['funs']:array();
        $com_models = isset($data['com_funs'])?$data['com_funs']:array();

        //未授权
        if(empty($user_models)){
            throw new CErrorException('账号已过期,请联系管理员',500);
        }

        if($user['user_classify'] == UserClassifyEnum::ADMIN || $user['user_level'] > 0){//超级管理员 或 领导
            Session::setIsLeader(1);
        }else{//用户
            Session::setIsLeader(0);
        }

        //判断是否需要注册IM 出现这个现象是因为该公司数据转移过服务器产生
        if($user['user_classify'] != UserClassifyEnum::ADMIN && $user['last_do_time_api'] == -1){
            if(isset($_POST['u_pass']) && $_POST['u_pass']){
                $pass = $_POST['u_pass'];
            }else{
                $pass = isset($params['pass'])?$params['pass']:'';
            }
            if($pass == ''){
                throw new CErrorException('转移数据后的公司首次登录参数传递缺少pass',500);
            }
            $res = IM::instance()->addUser($user['id'],$pass,$user['name']);
            if(!$res){
                throw new CErrorException('IM用户转移注册失败，请联系技术支持',500);
            }

            UpdateModel::make('user')->addData(array(
                'last_do_time_api' => time()
            ))->addColumnsCondition(array(
                'id' => $user['id']
            ))->execute();
        }

        Session::setComType($data['com_type']);
        Session::setUserClassify($user['user_classify']);
        Session::setUserModules($user_models);
        Session::setComModules($com_models);
        Session::setEarningReport($data['earning_report']);
        Session::setCreateChild($data['is_create_child']);
        Session::setMoreWarehouse($data['is_more_warehouse']);
        Session::setHaveStock($data['is_more_warehouse']);
        Session::setAdminLogo($data['admin_logo']);
        Session::setPrinterNum($data['printer_num']);
        Session::setShowImsi($data['is_show_imsi']);
        Session::setFactoryUnion($data['is_factory_union']);

        if($user['user_classify'] != UserClassifyEnum::ADMIN){
            $verinfo = $data['verinfo'];
            Session::setVersion($verinfo);
            if(!empty($verinfo) && $user['soft_version'] != $verinfo['id']){
                UpdateModel::make('user')->addData(array(
                    'soft_version' => $verinfo['id']
                ))->addColumnsCondition(array(
                    'id' => $user['id']
                ))->execute();

                Session::setIsAutoShowVersion(true);
            }else{
                Session::setIsAutoShowVersion(false);
            }
        }

    }

}