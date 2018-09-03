<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\Utility;

$utility = new Utility();

/* @var $this yii\web\View */
/* @var $model common\models\Department */
/* @var $form yii\widgets\ActiveForm */
;
if (!$model->isNewRecord) {
    $this->title = 'Update - ' . $model->name . '';
    $pageType = 'Update';
} else {
    $this->title = 'Create - Role ';
    $pageType = 'Create';
}
?>
<div class="col-md-12 col-sm-12 col-xs-12">
  
            <div class="x_panel ibox float-e-margins">
               <!-- <div class="ibox-title form-layout"></div>-->
                <div class="ibox-content b_radius6">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php $form = ActiveForm::begin(); ?>
                            <div class="row">    
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'name')->textInput(array('placeholder' => 'example: staff')) ?>

                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'description')->textarea() ?>
                                </div>
                            </div>
                            <div class="form-group ">  
                                <label class="control-label">Permissions</label>
                                    <?= $this->render("../widgets/_list_permission.php", ['leftListBox' => $leftListBox, 'rightListBox' => $rightListBox]) ?>
                               
                            </div>

                            <div class="row">        
                                <div class="col-sm-6">
                                    <?= Html::submitButton($pageType, ['class' => $model->isNewRecord ? 'btn btn-primary btn-sm' : 'btn btn-primary btn-sm']) ?>
                                    <a class="btn btn-primary btn-sm" href="<?= Url::toRoute('role/index') ?>">Cancel</a>
                                    <input type="button" class="btn btn-primary btn-sm" onclick="clearForm()" value="Clear"/>
                                </div>
                            </div>    
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
   
</div>
