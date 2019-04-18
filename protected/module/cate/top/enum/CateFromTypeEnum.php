<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 14:51
 */

namespace module\cate\top\enum;


use CC\util\arr\ArrayUtil;
use CC\util\db\Enum;
use module\cate\top\server\CateResortServer;

class CateFromTypeEnum extends Enum
{
    protected function initAddDatas()
    {

        $data = CateResortServer::getCateForResortInfo();
        $res = $this->setChilrenCateLength($data);
        $this->addForArray(ArrayUtil::arrayColumn($res, 'cate_name', 'id'));
    }

    private function setChilrenCateLength($data)
    {
        foreach ($data as $k=>$v){

            if($v['pid'] != 0){
                $data[$k]['cate_name'] = '|'.str_repeat('-',$v['level']*2).$data[$k]['cate_name'];
            }
        }

        return empty($data)?['0'=>'xxxx']:$data;
    }
}