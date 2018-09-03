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
$this->title = 'update - User Role | ';
$pageType = 'Update';
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
                             <?php    $listData=ArrayHelper::map($user,'id','username');
							 
								echo $form->field($model, 'user_id')->dropDownList(
								$listData, 
								['prompt'=>'Select...',

								'onchange'=>'location = "/role/assignrole?id="+'
									. 'this.options[this.selectedIndex].value;'
								]);	?>


                            </div>
							<div class="form-group col-sm-12">  
								<div class="col-sm-12">
									<label class="control-label">Permissions</label>
									<?= $this->render("../widgets/_list_permission.php", ['leftListBox' => $leftListBox, 'rightListBox' => $rightListBox]) ?>
								</div>
							</div>
                            <div class="col-sm-12">        
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
