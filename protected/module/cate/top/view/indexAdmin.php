<?php
/**
 * User: Lh
 * Date: 2019/4/18
 * Time: 11:27
 */

use CC\util\common\widget\panel\ListBodyPanel;
use CC\util\common\widget\panel\ListBtnPanel;
use CC\util\common\widget\panel\ListSearchPanel;
use CC\util\common\widget\panel\ListTablePanel;
use CC\util\common\widget\widget\buttons\ButtonWidget;
use CC\util\common\widget\widget\buttons\EditAjaxButtonWidget;
use CC\util\common\widget\widget\buttons\GroupButtonsWidget;
use CC\util\common\widget\widget\FilterWidget;
use CC\util\common\widget\widget\ListTableWidget;
use CC\util\common\widget\widget\WidgetBuilder;
?>


<?php
echo WidgetBuilder::build(
    new FilterWidget($this,[
        'is_asyn' => true,
        'action' => $this->genurl(''),
    ]),
    ListSearchPanel::instance()
);


echo ListBodyPanel::instance()->setId('_version_body_panel')->start();

    $buttons=[
        (new EditAjaxButtonWidget('新增', 'alt'))->setOptions(['success-after'=>'editAfterSuccess'])->addClassnames(' version_add'),
        (new ButtonWidget('排序', 'sort'))->addClassnames('onclick_sort'),
    ];

    echo WidgetBuilder::build(
        new GroupButtonsWidget($buttons, []), ListBtnPanel::instance()
    );

    echo WidgetBuilder::build(
        new ListTableWidget($this,$list,$page,[
            'is_show_sequence' => FALSE,
        ]),ListTablePanel::instance()->setId('__soft_version_table')
    );

echo ListBodyPanel::instance()->end();
?>
<script type="text/javascript">
    function editAfterSuccess() {
        reload_element('#_version_body_panel .list-table-panel',
            '<?php echo \CC::app()->url->genurl('index'); ?>');
    }
    var sort = $(".onclick_sort");
    sort.css('margin-left','10px');
    sort.attr({'onclick':'submit_sort()','href':'#','title':'数值越大越靠前'});

    function submit_sort(){
        var data = [];
        $('.sort').each(function(){
            var val = $(this).val().toString();
            var name = $(this).prop('name');
            data.push(name+'_'+val);
        });
        var post_data =data.join('|');

        var url ='<?php echo \CC::app()->request->url->genurl('sort'); ?>';
        ajax_request(url,{'post_data':post_data},function(data){
            if(data['ok']){
                Tip(data['msg']);
                setTimeout(function() {
                    window.parent.location.reload();
                }, 800);
            }
        })
    }
</script>
