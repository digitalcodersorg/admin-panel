<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$bundle = yiister\gentelella\assets\Asset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?= Url::toRoute("images/apple-icon-57x57.png");?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= Url::toRoute("images/apple-icon-60x60.png");?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= Url::toRoute("images/apple-icon-72x72.png");?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= Url::toRoute("images/apple-icon-76x76.png");?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= Url::toRoute("images/apple-icon-114x114.png");?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= Url::toRoute("images/apple-icon-120x120.png");?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= Url::toRoute("images/apple-icon-144x144.png");?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= Url::toRoute("images/apple-icon-152x152.png");?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= Url::toRoute("images/apple-icon-180x180.png");?>">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?= Url::toRoute("images/android-icon-192x192.png");?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= Url::toRoute("images/favicon-32x32.png");?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= Url::toRoute("images/favicon-96x96.png");?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= Url::toRoute("images/favicon-16x16.png");?>">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
    <script type="text/javascript">JS_BASE_URL="<?= Url::toRoute("/");?>";</script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php 
    if (!empty(Yii::$app->user->identity->id) && Yii::$app->controller->action->id != 'afterlogin' && Yii::$app->controller->action->id != '2fa') {
        $class ='nav-'. (!empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md');
    }else{
        $class = 'login';
    }
?>
<body class="<?= $class?> " >
    <div id="myProgress" style="display:none">
  <div id="myBar"></div>
</div>
<?php $this->beginBody(); ?>
     <!--navigation bar starts-->
     <div id="block-ui" style="display:none;"> 
         <i class="fa fa-gear fa-spin" style="font-size:50px;color:#2098ff;"></i>
     </div> 
     
     
<div class="container body">  
    <?php
    if (!empty(Yii::$app->user->identity->id) && Yii::$app->controller->action->id != 'afterlogin' && Yii::$app->controller->action->id != '2fa') {
    echo '<div class="main_container">';
        echo $this->render('/widgets/left_nav_panel');
        echo $this->render('/widgets/top_nav_panel');

    ?>
      
        <!-- page content -->
        <div class="right_col" role="main">
            <?php if (isset($this->params['h1'])): ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->params['h1'] ?></h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; }?>
            <div class="clearfix"></div>

            <?= $content ?>
        </div>
        <!-- /page content -->
        <?php
            if (!empty(Yii::$app->user->identity->id) && Yii::$app->controller->action->id != 'afterlogin' && Yii::$app->controller->action->id != '2fa') {
                echo $this->render('../widgets/footer');
                
            }
            echo '</div>'; 
            ?>
</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
