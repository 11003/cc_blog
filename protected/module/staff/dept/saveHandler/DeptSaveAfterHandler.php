<?php
/**
 * User: Hermit
 * Date: 2019/01/09
 * Time: 16:51
 */

namespace module\staff\dept\saveHandler;

use ApproveServer;
use biz\Encrypt;
use CC\action\saveHandler\ISaveAfterHandler;
use CC\db\base\insert\InsertModel;
use CC\db\base\select\ItemModel;
use CC\db\base\select\ListModel;
use CC\db\base\update\UpdateModel;
use CErrorException;
use CRequest;
use Order;
use ProcessProgress;
use Schema;

class DeptSaveAfterHandler implements ISaveAfterHandler
{

    private $_parent = null;

    private function checkData($data,$old_id){
        if ($data['name'] == '') {
            throw new CErrorException('部门名称不可以为空');
        }

        if($data['parent_id']){
            $this->_parent = ItemModel::make('dept')->addColumnsCondition([
                'id' => $data['parent_id']
            ])->execute();
            if(!$this->_parent){
                throw new CErrorException('父亲部门不存在');
            }
        }else{
            $this->_parent['id'] = 0;
        }

        if($old_id > 0){
            $condition = 'id != ? and name = ?';
            $params = [$old_id,$data['name']];
        }else{
            $condition = 'name = ?';
            $params = [$data['name']];
        }
        $detp = ItemModel::make('dept')->addStrCondition($condition,$params)->execute();
        if($detp){
            throw new CErrorException('该部门已经存在');
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
            'p_id' => $this->_parent['id'],
            'update_time' => time()
        ];

        if($is_add){
            $upsert_data['create_time'] = time();
        }

        if($is_add){
            $id = InsertModel::make('dept')->addData($upsert_data)->execute();
            if(!$id){
                throw new CErrorException('员工添加失败');
            }
        }else{
            $id = $old_data['id'];

            UpdateModel::make('dept')->addColumnsCondition([
                'id' => $id
            ])->addData($upsert_data)->execute();
        }

        $this->updateLkeyRkey();
    }

    private function getDeptTreeData(){
        $arr = ListModel::make('dept')->execute();

        $data = array();
        foreach($arr as $item){
            $data[$item['id']] = array(
                'id' => $item['id'],
                'name' => $item['name'],
                'pid' => $item['p_id'],
                'child' => array()
            );
        }

        return $this->arrayToTree($data);
    }

    private function arrayToTree($data){
        $tree = [];
        if(empty($data)){
            return $tree;
        }

        foreach($data as $v){
            $pid = $v['pid'];
            $id = $v['id'];
            if(isset($data[$pid])){
                $data[$pid]['child'][$id] = &$data[$id];
            }else{
                $tree[] = &$data[$id];
            }
        }

        return $tree;
    }

    //重新计算部门的 l 和 r 值用于查找下属 上级 排序 等等
    private function updateLkeyRkey(){
        $tree_data = $this->getDeptTreeData();;

        //计算并更新值
        $this->dealDeptSortData($tree_data);
    }

    private function dealDeptSortData($tree_data,&$sort = 0){
        foreach($tree_data as $dept){
            $sort++;
            $update_data['l_key'] = $sort;

            if(isset($dept['child']) && !empty($dept['child'])){
                self::dealDeptSortData($dept['child'],$sort);
            }

            $sort++;
            $update_data['r_key'] = $sort;

            //修改部门左右值
            UpdateModel::make('dept')->addColumnsCondition([
                'id' => $dept['id']
            ])->addData($update_data)->execute();
            //修改员工左右值
            UpdateModel::make('staff')->addColumnsCondition([
                'dept_id' => $dept['id']
            ])->addData($update_data)->execute();
        }
    }

}