<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Department */

$this->title = Yii::t('app', 'Create Department');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="x_panel  department-create">

    <?= $this->render('_form', [
        'model' => $model,
        'addressModel' => $addressModel,
        'leftListBox' => $leftListBox,
        'rightListBox' => $rightListBox,
        'userList' => $userList,
        'branchList' => $branchList,
    ]) ?>

</div>
