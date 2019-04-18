<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 11:47
 */

namespace module\cate\top;


use CC\action\SaveAction;
use CC\util\common\widget\form\creator\PostNamesCreator;
use CC\util\common\widget\form\HiddenInput;
use CC\util\common\widget\form\IFormViewBuilder;
use CC\util\common\widget\form\IInput;
use CC\util\common\widget\form\RadioButtonListInput;
use CC\util\common\widget\form\SelectInput;
use CC\util\common\widget\form\TextInput;
use module\cate\top\enum\CateFromTypeEnum;
use module\cate\top\handler\CateTopBeforeSaveHandler;


class CateTopAltAdminAction extends SaveAction implements IFormViewBuilder
{
    protected $isLayout = false;
    protected function getTable()
    {
        return 'cate';
    }

    /**
     * @return string "name,pass"
     */
    protected function getPostNames()
    {
        return PostNamesCreator::create($this);
    }

    protected function onBeforeSave(&$data)
    {
        return [
            new CateTopBeforeSaveHandler()
        ];
    }

    /**
     * @return  IInput[]
     */
    public function createFormInputs()
    {
        $inputs = [];
        $inputs[] = new HiddenInput('id');
        $inputs[] = new TextInput('cate_name','栏目名称',['must']);
        $inputs[] = new RadioButtonListInput('type','栏目类型',[1=>'文章列表',2=>'单页'],1,['style'=>2]);
        $inputs[] = new SelectInput('pid','上级栏目',CateFromTypeEnum::getValues(),['must']);
        return $inputs;
    }




}