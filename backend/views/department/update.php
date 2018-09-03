<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Department */

$this->title = Yii::t('app', 'Update Department: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="department-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'addressModel' => $addressModel,
        'userList' => $userList,   
    ]) ?>

</div>
