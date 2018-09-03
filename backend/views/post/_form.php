<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */

$post_type = empty($model->post_type) ? $post_type : $model->post_type;
$post = ($post_type == 'posts') ? 'Post' : 'Page';
?>
<?php $form = ActiveForm::begin(["id" => "create-post", 'options' => ['enctype' => 'multipart/form-data'],]); ?>
<div class="post-form">
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'post_title')->textInput(['maxlength' => true])->label($post.' Title') ?>
            <?= $form->field($model, 'post_url')->textInput(['maxlength' => true])->label($post.' URL') ?>
            <div class="thumbnail-area">
                <?php $avatar = empty($model->post_thumbnail) ? Url::to(['/']) . 'images/media_default_thumbnail.png' : $model->post_thumbnail; ?>
                <img src="<?= $avatar ?>" class="img-responsive post-thumb"/>
                <input type="file" name="post-thumb" value=""/>
            </div>
            <?php // $form->field($model, 'post_thumbnail')->fileInput()  ?>
        </div>
        <div class="col-md-4">
            <?php if ($post_type == 'posts') { ?>
            <?= $form->field($model, 'post_date')->textInput(['value' => empty($model->post_date) ? date('Y-m-d H:i:s') : $model->post_date, 'class' => 'form-control calender-datetime']) ?>
            <?php }?>
            <?= $form->field($model, 'post_status')->dropDownList(['draft' => 'Draft', 'publish' => 'Publish', 'pending' => 'Pending',], ['prompt' => 'Status'])->label($post.' Statue') ?>
            <?= $form->field($model, 'post_parent')->dropDownList([], ['prompt' => 'No Parent'])->label($post.' Parent') ?>
            <?= $form->field($model, 'menu_order')->textInput(['value' => empty($model->menu_order) ? 0 : $model->menu_order]) ?>
            <?php if ($post_type == 'posts') { ?>
                <div class="form-group field-post-comment_status">
                    <input type="hidden" name="Post[comment_status]" value="<?= empty($model->comment_status) ? 'open' : $model->comment_status ?>">
                    <label class="checkbox-container"> 
                        <input type="checkbox" checked="true" id="post-comment_status" name="Post[comment_status]" value="view-order"> <i></i> <strong>Comment enabled</strong> 
                        <span class="checkmark"></span>
                    </label>

                    <div class="help-block"></div>
                </div>
            <?php } ?>   

        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'post_content')->textarea(['rows' => 4,'class'=>'text-editor'])->label($post.' Content') ?> 
        </div>
    </div>

    <?= $form->field($model, 'post_type')->hiddenInput(['value' => $post_type])->label(false) ?>
    <?= $form->field($model, 'created_by')->hiddenInput(['value' => empty($model->created_by) ? Yii::$app->user->identity->id : $model->created_by])->label(false) ?>
    <?= $form->field($model, 'post_author')->hiddenInput(['value' => empty($model->post_author) ? Yii::$app->user->identity->id : $model->post_author])->label(false) ?>

    <?= $form->field($model, 'updated_by')->hiddenInput(['value' => empty($model->updated_by) ? Yii::$app->user->identity->id : $model->updated_by])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::Button(Yii::t('app', 'Clear'), ['class' => 'btn btn-primary', 'onclick' => "return clearForm('create-post');"]) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Url::toRoute('/post'), ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>