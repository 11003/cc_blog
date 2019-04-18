<?php
use CC\util\common\server\AssetManager;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" >
        <meta name="renderer" content="webkit">
        <link rel="icon" href="<?php echo \CC::app()->baseUrl.'/public/web/logo.ico'; ?>" type="image/x-icon">
        <title>后台 - CC Blog</title>

        <script type="text/javascript">
            var baseUrl = '<?php echo $baseUrl ?>';
            var baseUrlGroup = '<?php echo $baseUrl.'/'.CC::app()->url->getGroup() ?>';
        </script>
        <?php echo AssetManager::instance()->getAdminCssJs();?>
        <?php echo AssetManager::instance()->getCssJs(array_merge([
            '/public/admin/css/admin.css',
            '/public/admin/js/admin.js',
        ],$options['common_cssJs']));?>

    </head>

    <body class="<?php echo $_GET['hasretract'] ? 'body_hasretract' : '' ?> body_wq">

        <div class="main-container clearfix  " >
            <div class="header">
                <div class="header_left">
                    <a href="<?php echo $options['home_url']; ?>"
                       style="background: none;font-size: 20px;color:#EEE"
                       class="header_logo">
                        CC Blog
                    </a>
                </div>
                <ul class="header_right">

                    <?php if(isset($options['widget'])):?>
                        <?php foreach($options['widget'] as $top_nav_widget): ?>
                            <?php if(method_exists($top_nav_widget,'isNeedLi') && !$top_nav_widget->isNeedLi()): ?>
                                <?php echo \CC\util\common\widget\widget\WidgetBuilder::build($top_nav_widget) ?>
                            <?php else: ?>
                                <li>
                                   <?php echo \CC\util\common\widget\widget\WidgetBuilder::build($top_nav_widget) ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif;?>

                    <li class="header_user">
                        <span class="header_user_name">
                            <img src="<?php echo $baseUrl;?>/public/common/images/default_avatar.png" alt="" class="header_user_avatar">
                            <?php echo \CC\util\common\server\SessionAbs::getName() ?>
                        </span>
                        <div class="header_user_more">
                            <span class="header_user_up"></span>

                            <?php if(isset($options['personage_widget'])):?>
                                <?php foreach($options['personage_widget'] as $personage_widget): ?>
                                    <?php echo \CC\util\common\widget\widget\WidgetBuilder::build($personage_widget) ?>
                                <?php endforeach; ?>
                            <?php endif;?>

                            <a href="<?php echo CC::app()->url->genurl('/core/login/logout') ?>" class="header_user_quit">退出</a>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="sidebar">
                <?php echo \CC\util\common\widget\widget\WidgetBuilder::build(new \CC\util\common\widget\widget\LeftNavWidget($left_conf,null,$options['left_nav_options'] )); ?>
            </div>
            <div class="main-content">
                <div class="breadcrumbs" >
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?php echo CC::app()->url->genurl('/core/index/index'); ?>">首页</a>
                        </li>
                        <?php foreach ($options['breadcrumbs'] as $breadcrumb): ?>
                            <li>
                                <a href="<?php echo $breadcrumb['url'];?>"><?php echo $breadcrumb['name'];?></a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <div class="content">
                    <?php echo $content; ?>
                </div>

            </div>
        </div>

        <script type="text/javascript">
            $('.header_user_name').mousedown(function(){
                $('.header_user_more').toggle();
            });
            $('.header_user').mouseleave(function(){
                $('.header_user_more').hide();
            });
        </script>

    </body>


</html>