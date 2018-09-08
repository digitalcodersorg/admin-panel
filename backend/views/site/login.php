<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
              <h1>Admin Login</h1>
              <div>
                 <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
              </div>
              <div>
                <?= $form->field($model, 'password')->passwordInput() ?>
              </div>
              <div class="login-btn">
                  <?= Html::submitButton('Login', ['class' => 'btn btn-default submit', 'name' => 'login-button']) ?>
                <a class="reset_pass" href="site/forgotpassword">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div>
                  <h1><i class="fa fa-paw"></i> Admin Panel</h1>
                  <p>©<?= date('Y');?> All Rights Reserved. Admin Panel is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            <?php ActiveForm::end(); ?>
          </section>
        </div>
        </div>