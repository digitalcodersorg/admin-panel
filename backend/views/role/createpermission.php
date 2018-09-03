<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\Utility;
use yii\helpers\ArrayHelper;

$utility = new Utility();

/* @var $this yii\web\View */
/* @var $model common\models\Department */
/* @var $form yii\widgets\ActiveForm */
if (!empty($id)) {
    $this->title = 'Update - ' . $model->name . ' |  ';
    $pageType = 'Update';
} else {
    $this->title = 'Create - Permission | ';
    $pageType = 'Create';
}
?>
<div class="wrapper wrapper-content animated fadeInRight fix-page-height">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title form-layout"></div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php $form = ActiveForm::begin(); ?>
                            <div class="col-sm-12">    
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'name')->textInput(array('placeholder' => 'example: create-user'))->label("Unique name"); ?>

                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'description')->textarea() ?>
                                </div>
                            </div>

                            <div class="col-sm-12">  
                                <div class="col-sm-6">
                                    <?php
                                    $listData = ArrayHelper::map($authRule, 'name', 'name');

                                    echo $form->field($model, 'group_name')->dropDownList(
                                            $listData, ['prompt' => 'Select Group'])->label('Group');
                                    ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= Html::submitButton($pageType, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                    <a class="btn btn-warning" href="<?= Url::toRoute('role/index') ?>">Cancel</a>
                                    <input type="button" class="btn btn-info" onclick="clearForm()" value="Clear"/>
                                </div>
                            </div>    
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
