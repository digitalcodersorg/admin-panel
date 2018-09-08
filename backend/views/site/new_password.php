<?php
$this->title = 'New Password';

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>

<div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <?php $form = ActiveForm::begin(['action'=>'changepasswords','id' => 'forgot-form']); ?>
    
                <h1>Change password</h1>
                    <div class="form-group">
                        <input type="password" id="newPasswordForgot" class="form-control" placeholder="New Password">
                    </div>
                    <div class="form-group">
                        <input type="password" id="newPasswordForgotConfirm" class="form-control" placeholder="Confirm Password">
                    </div>
                    <input type="hidden" id="emailIdNewPassword" value="<?= $email ?>">
                    <input type="hidden" id="reNewPassword" value="<?= $re ?>">

                    <button class="btn btn-default  full-width" >Submit</button>
                        
                     <a href="<?= Url::toRoute('site/index') ?>"  class="btn btn-primary" style="margin-top:5px;">
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
