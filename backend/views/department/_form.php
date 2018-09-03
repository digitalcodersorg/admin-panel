<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Department */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="department-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6 form-group">
        <?= $form->field($model, 'type')->dropDownList(['Department' => 'Department', 'Branch' => 'Branch',], ['prompt' => 'Select Type']) ?> <br />
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-6 form-group">
        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    </div>
    <div class="col-md-6 form-group">
        <?= $form->field($model, 'status')->dropDownList(['Active' => 'Active', 'Inactive' => 'Inactive',], ['prompt' => 'Select Status']) ?> 
    </div>
    
    <div class="col-md-6 form-group">
        <?= $form->field($model, 'department_head')->dropDownList($userList, ['prompt' => 'Select department head'])->label('Department Head') ?>

    </div>
    <div class="col-md-6 form-group parent-branch <?= ($model->type == 'Branch') ? 'hide' : ''?>">
        <?= $form->field($model, 'parent')->dropDownList($branchList, ['prompt' => 'Select Branch'])->label('Branch') ?>
    </div> 
    <div class="form-group  department-user <?= ($model->type == 'Branch') ? 'hide' : ''?>">
        <div class="col-sm-12">
            <label class="control-label">Department Users</label>
            <?= $this->render("../widgets/_list_box.php", ['leftListBox' => (empty($leftListBox) ? [] : $leftListBox), 'rightListBox' => (empty($rightListBox) ? [] : $rightListBox)]) ?>
        </div>
    </div>
    <div class="branch-address <?= ($model->type == 'Branch') ? '' : 'hide'?>">
        <?php echo $this->render('../widgets/_addressForm', ['form' => $form, 'addressModel' => $addressModel, 'label' => "Branch Address"]); ?>
    </div>
     
    <div class="clearfix"></div>
    <div class="col-sm-12 form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
