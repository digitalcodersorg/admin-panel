<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Utility;
use yii\bootstrap\Button;

$utility = new Utility();

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Role List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="alert btn-area"> 
        <form action="" id="filterForm">
            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <input type="text" id="filter_name" onkeypress="if (event.keyCode === 13) {
                            return searchFilter();
                        }" name="filter_name" value="<?php
                       if (!empty($_GET['filter_name'])) {
                           echo $utility->validateSearchKeywords($_GET['filter_name']);
                       }
                       ?>" placeholder="Role Name" class="form-control">
            </div>
            <?= Button::widget(['label' => 'Search', 'options' => ['class' => 'btn-primary'],]); ?>
            <?= Button::widget(['label' => 'Clear', 'options' => ['class' => 'btn-primary', 'onclick' => "return clearFilter('role');"]]); ?>
            <?= Html::a('Create Role', Url::toRoute('role/updaterole'), ['class' => 'btn btn-primary']) ?>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action <?= empty($userList) ? '' : 'dataTable' ?>">
            <thead>
                <tr>
                    <th>Role Name</th>
                    <th>Description</th>
                    <th>Update On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($userList)) {
                    foreach ($userList as $user) {
                        ?>
                        <tr>
                            <td>
                                <?= $user['name'] ?>
                            </td>
                            <td>
                                <?= $user['description'] ?>
                            </td>
                            <td>
                                <?= $utility->getDateFormatForList($user['updated_at']); ?> 
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="<?= Url::toRoute('role/updaterole?name=' . $user['name']) ?>" title="Update"><i class="glyphicon glyphicon-pencil"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td style='text-align:center;' colspan='7'> No records found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>