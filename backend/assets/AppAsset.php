<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jquery.dataTables.min.css',
        'css/bootstrap-datetimepicker.css',
        //'css/jquery.mCustomScrollbar.min.css',
        'css/chosen/chosen.css',
        'css/bootstrap-duallistbox.css',
        'css/site.css?21',
    ];
    public $js = [
        'js/moment.min.js',
        'js/bootstrap-datetimepicker.js',
        'js/jquery.dataTables.min.js',
        'js/chosen.jquery.js',
        //'js/jquery.mCustomScrollbar.concat.min.js',
        'js/tinymce/tinymce.min.js',
        'js/jquery.bootstrap-duallistbox.js',
        'js/Highcharts-4.2.1/js/highcharts.js',
        'js/jquery.blockUI.js',
        'js/admin.js?232',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
