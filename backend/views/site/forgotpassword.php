<?php

use common\models\Utility;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
$this->title = 'Forgot Password';
?>
<div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <?php $form = ActiveForm::begin(['id' => 'forgot-form']); ?>
                <h1>Forgot Password</h1>
                <!--<p> Enter your email address and your password will be reset and emailed to you.</p>-->
                <p>Enter your registered email address to receive the reset password link</p>
            
                            <div class="form-group">
                                <input type="email" name="emailId" id="emailForgetPassword" class="form-control" placeholder="Email address" required="">
                            </div>

                <span style="font-weight: 600;" class="btn btn-default submit  full-width forgot-form-submit" >Send reset link</span>
                <p class="text-error hide">Password reset link sent to your registered email id.</p>

                            <a href="<?= Url::toRoute('site/index') ?>"  style="margin-top:5px;">
                                Go Back
                            </a>
                       
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
