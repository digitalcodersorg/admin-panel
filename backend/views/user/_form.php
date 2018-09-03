<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\AuthItem;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
   <?php $form = ActiveForm::begin(["id" => "create-user", 'options' => ['enctype' => 'multipart/form-data'],]); ?>
    <div class="col-md-6 form-group">
        <?= $form->field($model, 'username')->textInput(['maxlength' => true,'readOnly'=>($model->scenario == 'update')? "readonly" : false]) ?>
    </div>
    <div class="col-md-6 form-group">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6 form-group">
        <?= $form->field($model, 'password_hash')->passwordInput(['value'=>'']); ?>
    </div>
    <div class="col-md-6 form-group">
        <?= $form->field($model, 'confirm_password')->passwordInput() ?>
    </div>

    <div class="col-md-6 form-group">
        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-6 form-group">
        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
    </div>



    <div class="col-md-6 form-group">
        <?= $form->field($model, 'gender')->dropDownList(['male' => 'Male', 'female' => 'Female', 'other' => 'Other',], ['prompt' => 'Gender']) ?>
    </div>

    <div class="col-md-6 form-group">
        <?= $form->field($model, 'date_of_birth')->textInput(['class' => 'form-control calender',]) ?>
    </div>

    <div class="col-md-6 form-group">
        <?= $form->field($model, 'cms_user_contact_no')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6 form-group">
       <?php
        $AuthItem = AuthItem::find()->where('type = :type', [':type' => 1])->all();
        $listData = ArrayHelper::map($AuthItem, 'name', 'name');
        echo $form->field($model, 'role')->dropDownList($listData, ['multiple' => 'multiple']);
        ?>
    </div>


    <div class="col-md-6 form-group">
        <?php
        $params = Yii::$app->params;
        if (!empty($id) && !empty($user_level)) {
            $model->user_level = $user_level[0]['level'];
        }
        ?>
        <?= $form->field($model, 'user_level')->dropDownList($params['userLevel']); ?>
    </div>
    <div class="col-md-6 form-group">
        <?= $form->field($model, 'status')->dropDownList(['Active' => 'Active', 'Inactive' => 'Inactive',], ['prompt' => 'Select Status']) ?> 
    </div>
    <div class="col-md-6 form-group">
        <?php $avatar = empty($model->cms_user_avatar) ? (Url::to(['/']) . 'images/user-icon.png') : Yii::$app->params['aws']['CDN_URL'].$model->cms_user_avatar; ?>
        <img src="<?= $avatar ?>" id="img-container" class="img-responsive user-profile-icon"/>
        
        <?= $form->field($model, 'cms_user_avatar')->fileInput(['accept' => "image/*", 'id' => 'profile-img', "class" => "upload"])->label('') ?>
      
    </div>
    <div class="col-md-12 form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::Button(Yii::t('app', 'Clear'), ['class' => 'btn btn-primary', 'onclick' => "return clearForm('create-user');"]) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Url::toRoute('/user'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
