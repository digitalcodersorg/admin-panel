<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'post_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_thumbnail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_title')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'post_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_parent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'menu_order')->textInput() ?>

    <?= $form->field($model, 'comment_count')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_date')->textInput() ?>

    <?= $form->field($model, 'created_on')->textInput() ?>

    <?= $form->field($model, 'updated_on')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
