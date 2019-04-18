<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 18:33
 */

namespace module\article\manage;


use CC\action\SaveAction;
use CC\util\common\widget\form\HiddenInput;
use CC\util\common\widget\form\IFormViewBuilder;
use CC\util\common\widget\form\IInput;
use CC\util\common\widget\form\SelectInput;
use CC\util\common\widget\form\TextInput;

class ArticleManageAltAdminAction extends SaveAction implements IFormViewBuilder
{

    protected $isLayout = false;
    protected function getTable()
    {
        return 'article';
    }

    /**
     * @return  IInput[]
     */
    public function createFormInputs()
    {
        $inputs = [];
        $inputs[] = new HiddenInput('id');
        $inputs[] = new TextInput('name','名称',['must']);
        $inputs[] = new SelectInput('cid','所属栏目',[],['must']);
        return $inputs;
    }

    /**
     * @return string "name,pass"
     */
    protected function getPostNames()
    {
        // TODO: Implement getPostNames() method.
    }
}