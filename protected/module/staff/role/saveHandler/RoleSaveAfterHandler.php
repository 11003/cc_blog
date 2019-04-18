<?php
/**
 * User: Hermit
 * Date: 2019/1/10
 * Time: 14:13
 */

namespace module\staff\role\saveHandler;


use CC\action\saveHandler\ISaveAfterHandler;
use CC\db\base\delete\DeleteModel;
use CC\db\base\insert\InsertModel;
use CC\db\base\select\ItemModel;
use CErrorException;
use CRequest;

class RoleSaveAfterHandler implements ISaveAfterHandler
{

    public function onSaveAfter(&$data, CRequest $request, $is_add, $old_data, $action)
    {
        if($data['name'] == ''){
            throw new CErrorException('角色名不可以为空');
        }

        if($is_add){
            $condition = 'name = ?';
            $params = [$data['name']];
        }else{
            $condition = 'id != ? and name = ?';
            $params = [$data['id'],$data['name']];
        }
        $role = ItemModel::make('role')->addStrCondition($condition,$params)->execute();
        if($role){
            throw new CErrorException('该角色名已经存在');
        }

        if($is_add){
            $role_id = InsertModel::make('role')->addData([
                'name' => $data['name']
            ])->execute();
        }else{
            $role_id = $old_data['id'];
        }

        $auth_arr = isset($data['auth'])?$data['auth']:[];
        $insert_data = [];
        foreach($auth_arr as $auth => $data_val){
            $insert_data[] = [
                'role_id' => $role_id,
                'auth' => $auth,
                'data' => $data_val,
                'auth_range' => '',
            ];
        }

        //删除该角色以前的权限
        DeleteModel::make('role_auth')->addColumnsCondition([
            'role_id' => $role_id
        ])->execute();

        //插入新权限
        if(!empty($insert_data)){
            InsertModel::make('role_auth')->addDatas($insert_data)->execute();
        }
    }

}