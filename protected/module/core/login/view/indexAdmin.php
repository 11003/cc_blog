<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <link rel="icon" href="<?php echo \CC::app()->baseUrl.'/public/web/logo.ico'; ?>" type="image/x-icon">
    <title>后台 - 小步资源管理系统登录</title>
    <script type="text/javascript">
        var baseUrl = '<?php echo $baseUrl ?>';
    </script>
    <?php echo \CC\util\common\server\AssetManager::instance()->getBaseCssJs() ?>
       <?php echo \CC\util\common\server\AssetManager::instance()->getCssJs(array(
           '/public/admin/login/login.css',
           '/public/common/widget/module/core/login/js/login.js',
       )) ?>
</head>

<body>
<style>
    #logo_box{
        background: url(<?php echo \CC::app()->baseUrl.'/public/web/logo.png'; ?>) no-repeat center center;
        background-size:35% 35%;
        height:250px;
        margin-top: 100px;
    }
    .login_tit{
        margin-top: 0;
    }
</style>
<div class="main-content">
    <div class="main_c">
        <div class="form_w clearfix">
            <div id="logo_box"></div>
            <form action="" class="form_act" method="post">
                <div class="login_tit">小步资源管理</div>
                <fieldset>
                    <div class="block clearfix">
                        <span class="block input-icon  ">
                            <input class="form-control req the-padding-left"
                                   value="<?php echo \CC\util\common\server\Cookie::get('core_login_account') ?>" data-name="账号"
                                   placeholder="请输入登录帐号" type="text" name="account" id="account" />
                        </span>
                    </div>
                    <label class="block clearfix">
                    <span class="block input-icon ">
                        <input class="form-control req the-padding-left" data-name="密码"
                               placeholder="请输入帐号密码"
                               type="password" value="" name="pass" id="pass" />
                    </span>
                    </label>

                    <div class="space"></div>
                    <div class="clearfix">
                        <button type="submit" style="background-color: #ff8d1a" class="login_btn btn-danger btn-block">登 录</button>
                    </div>
                    <div class="space-4"></div>
                </fieldset>
            </form>
        </div>
        <div class="copyright">
            &copy; <?php echo date('Y') ?>
        </div>
    </div>
</div>
</body>
</html>