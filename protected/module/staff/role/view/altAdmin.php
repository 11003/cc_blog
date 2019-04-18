<style>
    #role_form{
        padding: 10px;
    }
    .row-group .data-label{
        text-align: left;
        min-height: 30px;
    }
    .row-group-line{
        width: 600px;
        margin-bottom: 15px;
    }
    .data-txt label{cursor: pointer;margin-right: 10px;}
    .row_title{
        font-size: 16px;
        font-weight: bold;
    }
</style>

<?php

use biz\auth\Auth;
use CC\util\common\widget\widget\RetrunBackWidget;
use CC\util\common\widget\widget\WidgetBuilder;

echo WidgetBuilder::build(new RetrunBackWidget('index'));

?>

<form id="role_form" method="post" action="">
    <div class="row-group clearfix">
        <label class="data-label required">角色名称
            <span class="required">*</span>
        </label>
        <div class="data-group">
            <input type="text" name="name" value="<?php echo $role['name']; ?>">
        </div>
    </div>

    <div class="row-group clearfix">
        <label class="data-label">角色权限</label>
        <div class="data-group">

            <!-- 业务管理 -->
            <div class="row-group-line">
                <div class="row_title">业务管理</div>

                <div class="row">
                    <div class="data-label">查看：</div>
                    <div class="data-txt">
                        <label>
                            <input name="auth[<?php echo Auth::BUSINESS_VIEW ?>]" value="<?php echo Auth::AUTH_RANG_NONE ?>"
                                <?php echo $auth_list[Auth::BUSINESS_VIEW]==Auth::AUTH_RANG_NONE?'checked="checked"':''; ?>
                                   type="radio"
                            />
                            不能查看
                        </label>

                        <label>
                            <input name="auth[<?php echo Auth::BUSINESS_VIEW ?>]" value="<?php echo Auth::AUTH_RANG_ME ?>"
                                <?php echo $auth_list[Auth::BUSINESS_VIEW]==Auth::AUTH_RANG_ME?'checked="checked"':''; ?>
                                   type="radio"
                            />
                            查看自己的
                        </label>

                        <label>
                            <input name="auth[<?php echo Auth::BUSINESS_VIEW ?>]" value="<?php echo Auth::AUTH_RANG_SUB ?>"
                                <?php echo $auth_list[Auth::BUSINESS_VIEW]==Auth::AUTH_RANG_SUB?'checked="checked"':''; ?>
                                   type="radio"
                            />
                            查看下属的
                        </label>

                        <label>
                            <input name="auth[<?php echo Auth::BUSINESS_VIEW ?>]" value="<?php echo Auth::AUTH_RANG_ALL ?>"
                                <?php echo $auth_list[Auth::BUSINESS_VIEW]==Auth::AUTH_RANG_ALL?'checked="checked"':''; ?>
                                   type="radio"
                            />
                            查看所有
                        </label>
                    </div>
                </div>
            </div>

            <!-- 人员管理 -->
            <div class="row-group-line">
                <div class="row_title">人员管理</div>

                <div class="row">
                    <div class="data-label">查看：</div>
                    <div class="data-txt">
                        <label>
                            <input name="auth[<?php echo Auth::STAFF_MANAGE; ?>]" value="<?php echo Auth::AUTH_RANG_ALL ?>"
                                <?php echo $auth_list[Auth::STAFF_MANAGE]==Auth::AUTH_RANG_ALL?'checked="checked"':''; ?>
                                   type="checkbox"
                            />
                            员工管理
                        </label>

                        <label>
                            <input name="auth[<?php echo Auth::ROLE_MANAGE; ?>]" value="<?php echo Auth::AUTH_RANG_ALL ?>"
                                <?php echo $auth_list[Auth::ROLE_MANAGE]==Auth::AUTH_RANG_ALL?'checked="checked"':''; ?>
                                   type="checkbox"
                            />
                            角色管理
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row-group clearfix">
        <label class="data-label"></label>
        <div class="data-group">
            <span id="save_btn" class="btn btn-primary">保存</span>
        </div>
    </div>
</form>

<script>
    $('#save_btn').click(function(){
        var url = '<?php echo $this->genurl('alt',$_GET); ?>';

        var post_data = $('#role_form').serialize();

        ajax_request(url,post_data,function(){
            window.history.back(-1);
        });
    });
</script>