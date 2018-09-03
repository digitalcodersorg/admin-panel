<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Post */
$post = ($post_type == 'posts') ? 'Post' : 'Page';
$this->title = Yii::t('app', 'Create '.$post);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $post), 'url' => ['post','post_type'=>$post_type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="x_panel post-create">
    <?= $this->render('_form', [
        'model' => $model,
        'post_type' => $post_type,
    ]) ?>
</div>
