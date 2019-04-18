<?php
/**
 * User: Hermit
 * Date: 2019/01/09
 * Time: 16:51
 */

namespace module\staff\staff\saveHandler;

use ApproveServer;
use biz\Encrypt;
use CC\action\saveHandler\ISaveAfterHandler;
use CC\db\base\insert\InsertModel;
use CC\db\base\select\ItemModel;
use CC\db\base\update\UpdateModel;
use CErrorException;
use CRequest;
use Order;
use ProcessProgress;
use Schema;

class StaffSaveAfterHandler implements ISaveAfterHandler
{

    private $_dept = null;
    private $_role = null;

    private function checkData($data,$old_id){
        if ($data['name'] == '') {
            throw new CErrorException('员工姓名不可以为空');
        }
        if ($data['account'] == '') {
            throw new CErrorException('帐号不可以为空');
        }
        if (!$data['dept_id']) {
            throw new CErrorException('所属部门不可以为空');
        }
        if (!$data['role_id']) {
            throw new CErrorException('角色类别不可以为空');
        }
        if(!$data['email']){
            throw new CErrorException('邮箱不可以为空');
        }

        $this->_dept = ItemModel::make('dept')->addColumnsCondition([
            'id' => $data['dept_id']
        ])->execute();
        if(!$this->_dept){
            throw new CErrorException('所属部门不存在');
        }

        $this->_role = ItemModel::make('role')->addColumnsCondition([
            'id' => $data['role_id']
        ])->execute();
        if(!$this->_role){
            throw new CErrorException('角色类别不存在');
        }

        if($old_id > 0){
            $condition = 'id != ? and account = ?';
            $params = [$old_id,$data['account']];
        }else{
            $condition = 'account = ?';
            $params = [$data['account']];
        }
        $staff = ItemModel::make('staff')->addStrCondition($condition,$params)->execute();
        if($staff){
            throw new CErrorException('该账户已经存在');
        }

    }

    /**
     * @param array    $data
     * @param CRequest $request
     * @param bool     $is_add
     * @param          $old_data
     * @param          $action
     *
     * @throws CErrorException
     */
    public function onSaveAfter(&$data, CRequest $request, $is_add, $old_data, $action)
    {
        $this->checkData($data,$old_data['id']);
        $upsert_data = [
            'name' => $data['name'],
            'account' => $data['account'],
            'avatar' => '',
            'dept_id' => $this->_dept['id'],
            'phone' => $data['phone'],
            'update_time' => time(),
            'l_key' => $this->_dept['l_key'],
            'r_key' => $this->_dept['r_key'],
            'role_id' => $this->_role['id'],
            'email' => $data['email']
        ];

        if($data['password']){
            $upsert_data['password'] = Encrypt::encodeStaffPwd($data['password']);
        }

        if($is_add){
            $upsert_data['create_time'] = time();
        }

        if($is_add){
            $id = InsertModel::make('staff')->addData($upsert_data)->execute();
            if(!$id){
                throw new CErrorException('员工添加失败');
            }
        }else{
            $id = $old_data['id'];

            UpdateModel::make('staff')->addColumnsCondition([
                'id' => $id
            ])->addData($upsert_data)->execute();
        }
    }

}