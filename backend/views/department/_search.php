<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DepartmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="department-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'name')->textInput(['placeholder' => "Search"])->label(false) ?>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
         <?= $form->field($model, 'type')->dropDownList(['branch' => 'Branch', 'Department' => 'Department'], ['prompt' => 'Select Type'])->label(false) ?>
    </div>
    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    <?= Html::a(Yii::t('app', 'Create'), ['update'], ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>

</div>
