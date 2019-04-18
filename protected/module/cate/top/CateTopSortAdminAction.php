<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 16:50
 */

namespace module\cate\top;


use CAction;
use CC\db\base\update\UpdateModel;
use CErrorException;
use CJsonData;
use CModel;
use CRequest;

class CateTopSortAdminAction extends CAction
{
    public function execute(CRequest $request)
    {
        $data = $_POST['post_data']?:'';
        $res = explode('|',$data);
        $transaction = CModel::model()->beginTransaction();
        foreach ($res as $k=>$v){
            $tree = explode('_',$v);
            $update = UpdateModel::make('cate')->addColumnsCondition(['id'=>$tree[0]])->addData(['sort'=>$tree[1]])->execute();
            if(!$update){
                $transaction->rollBack();
                throw new CErrorException('修改排序失败');
            }
        }
        $transaction->commit();
        return new CJsonData(['msg'=>'修改排序成功']);
    }
}