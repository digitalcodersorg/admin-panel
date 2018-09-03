<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\AuthAssignment;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users List';
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="user-index">

    <div class="alert btn-area">
        <form action="" id="user_index">
            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <input type="text" name="username" value="<?= $username?>" class="form-control" autocomplete="off" placeholder="Username or Email"/>
            </div>
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Clear'),['user/index'], ['class' => 'btn btn-primary',]) ?>
            <?php  if (Yii::$app->user->can('create-user')) { ?>
            <?= Html::a('Create User', ['update'], ['class' => 'btn btn-primary']) ?>
            <?php }?>
        </form>

        <div class="clearfix"></div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action dataTable">
            <thead>
                <tr class="headings">
                    <th class="column-title">Username </th>
                    <th class="column-title">Display Name</th>
                    <th class="column-title">Email </th>
                    <th class="column-title">Role</th>
                    <th class="column-title">Status </th>
                    <th class="column-title">User Since</th>
                    <?php  if (Yii::$app->user->can('update-user')) { ?>
                    <th class="column-title no-link last"><span class="nobr">Action</span>
                    </th>
                    <?php }?>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($users as $user){?>
                <tr class="even pointer">
                    <td class=" "><?= $user->username;?></td>
                    <td class=" "><?= $user->first_name .' '.$user->last_name;?></td>
                    <td class=" "><?= $user->email?></td>
                    <td class=" ">
                    <?php $roles = AuthAssignment::find()->select(['item_name'])->where(['user_id'=>$user->id])->createCommand()->queryAll();
                    if(!empty($roles)){
                        echo implode(', ', array_column($roles, 'item_name'));
                    }else{
                        echo 'NA';
                    }?>
                    </td>
                    <td class=" "><?= $user->status;?></td>
                    <td class=" "><?= $user->created_at;?></td>
                    <?php  if (Yii::$app->user->can('update-user')) { ?>
                    <td class=" last">  <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', Url::to(['user/update', 'id' => $user->id]), ['class' => '']) ?></td>
                    <?php }?>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
