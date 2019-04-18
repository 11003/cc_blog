<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 16:01
 */

namespace module\cate\top\handler;


use CC\action\saveHandler\ISaveBeforeHandler;
use CC\db\base\select\ListModel;
use CErrorException;
use CRequest;

class CateTopBeforeSaveHandler implements ISaveBeforeHandler
{
    public function onSaveBefore(&$data, CRequest $request, $is_add, $action)
    {

        $cate_res = ListModel::make('cate');
        if($data['id']){
            $cate_res = $cate_res->addStrCondition('id not in ('.$data['id'].')');
        }
        $cate_res = $cate_res->execute();
        foreach ($cate_res as $k => $v){
            if($data['cate_name'] == $v['cate_name']){
                throw new CErrorException('名称重复');
            }
        }
        if($is_add){
            $data['cate_name'] = time();
        }
    }
}