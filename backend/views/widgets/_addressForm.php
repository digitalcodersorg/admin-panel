<?php 
use common\models\Country;
$country = Country::getCountryList();
$state = Country::getStateList($addressModel->country);
$size = !isset($size) ? 12 : $size; 
$minimize = !isset($minimize) ? false : $minimize; 
$rand =  rand(); 
$no = isset($no) ? '['.$no.']' : '';
?> 
<div class="col-md-<?= $size ?> col-sm-<?= $size ?> col-xs-12 address">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-map-marker" aria-hidden="true"></i> <?= isset($label) ? $label : "Address" ?>   </h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-<?= ($minimize)? 'down' : 'up'?>"></i></a>
                </li>

            </ul>
            <div class="clearfix"></div>
        </div>
        <?php if(!empty($addressModel->ID)){?>
        <?= $form->field($addressModel, $no.'ID')->hiddenInput(['value' => $addressModel->ID])->label(false) ?>
        <?php }?>
        <div class="x_content" style="display: <?= ($minimize)? 'none' : ''?>">
            <div class="col-md-12 col-xs-12 form-group">
                <?= $form->field($addressModel, $no.'title')->textInput(['id'=>'title_'.$rand,'maxlength' => true]) ?>
            </div>
            <div class="col-md-12 col-xs-12 form-group">
                <?= $form->field($addressModel, $no.'address_line1')->textInput(['id'=>'addr1_'.$rand,'maxlength' => true]) ?>
            </div>
            <div class="col-md-12 col-xs-12 form-group">
                <?= $form->field($addressModel, $no.'address_line2')->textInput(['id'=>'addr2_'.$rand,'maxlength' => true]) ?>
            </div>
            <div class="col-md-6 col-xs-12 form-group">
                <?= $form->field($addressModel, $no.'land_mark')->textInput(['id'=>'land_mark_'.$rand,'maxlength' => true]) ?>
            </div>
            <div class="col-md-6 col-xs-12 form-group">
                <?= $form->field($addressModel, $no.'city')->textInput(['id'=>'city_'.$rand,'maxlength' => true]) ?>
            </div>
            <div class="col-md-6 col-xs-12 form-group">
                <?= $form->field($addressModel, $no.'phone_no')->textInput(['id'=>'phone_'.$rand,'maxlength' => true]) ?>
            </div>
            <div class="col-md-6 col-xs-12 form-group">
                <?= $form->field($addressModel, $no.'email')->textInput(['id'=>'email_'.$rand,'maxlength' => true]) ?>
            </div>
            <div class="col-md-4 col-xs-12 form-group country-input">
                <?= $form->field($addressModel, $no.'country')->dropDownList($country,['id'=>'contry'.$rand,'prompt' => 'Select Country...','class'=>'country-list form-control']) ?>
            </div>
            <div class="col-md-4 col-xs-12 form-group state-input">
                <?= $form->field($addressModel, $no.'state')->dropDownList($state,['id'=>'state'.$rand,'prompt' => 'Select Country...','class'=>'state-list form-control']) ?>
            </div>
            <div class="col-md-4 col-xs-12 form-group">
                <?= $form->field($addressModel, $no.'zip')->textInput(['id'=>'zip'.$rand,'maxlength' => true]) ?>
            </div>
        </div>
    </div>
</div>