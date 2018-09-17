<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Customer Information');
$this->params['breadcrumbs'][] = $this->title;
$user = new common\models\User;
?>
<div class="department-index">
    <div class="alert btn-area">
        <form action="" id="user_index">
            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <input type="text" name="username" value="<?= $username?>" class="form-control" autocomplete="off" placeholder="Type Username or Email or Company Name"/>
            </div>
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Clear'), ['user/customer-info'],['class' => 'btn btn-primary']) ?>
        </form>
        <div class="clearfix"></div>
    </div>

    <div class="table-responsive ">
        <table class="table table-striped jambo_table bulk_action ">
            <thead>
                <tr class="headings">
                    <th class="column-title">Login ID</th>
                    <th class="column-title">Company Name</th>
                    <th class="column-title">Email</th>
                    <th class="column-title">Phone</th>
                    <th class="column-title">AMC Type</th>
                    <th class="column-title">Updated On</th>
                    <?php if (Yii::$app->user->can('update-customer-info') || Yii::$app->user->can('view-customer-info')) { ?>
                    <th class="column-title no-link last"><span class="nobr">Action</span>
                    <?php }?>
                    </th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($users as $user): ?>
                    <tr>
                        <td><a href=""><?= $user->username ?></a></td>
                        <td><?= $user->getUsermeta($user->id, 'Company Name') ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->cms_user_contact_no ?></td>
                        <td>Yes</td>
                        <td><?= $user->updated_at ?></td>
                        <?php if (Yii::$app->user->can('update-customer-info') || Yii::$app->user->can('view-customer-info')) { ?>
                        <td>
                        <?php if(Yii::$app->user->can('view-customer-info')){ ?>  
                        <?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['view-customer', 'id' => $user->id], ['class' => 'btn btn-sm btn-info']) ?><?php }?><?php if(Yii::$app->user->can('update-customer-info')){ ?>
                        <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update-customer', 'user' => $user->id], ['class' => 'btn btn-sm btn-dark']) ?><?php }?>
                        </td>
                        <?php }?>
                    </tr>
<?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php
            echo LinkPager::widget([
                'pagination' => $pages,
            ]);
            ?>
        </div>

    </div>
</div>
