<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Comments List');
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="user-index">

    <div class="alert btn-area">
        <form action="">
            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <input type="text" name="search" class="form-control" autocomplete="off" placeholder="Search in comments"/>
            </div>
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Create User', ['update'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('All Rejected', ['comment/rejected'], ['class' => 'btn btn-danger']) ?>
        </form>

        <div class="clearfix"></div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title text-center" style="width: 50px"> #</th>
                    <th class="column-title">Comment Text </th>
                    <th class="column-title">Comment Post </th>
                    <th class="column-title">Comment By</th>
                    <th class="column-title">Status </th>
                    <th class="column-title">Created at</th>
                    <th class="column-title no-link last"><span class="nobr">Action</span>
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>
                        <label class="checkbox-container"> 
                            <input type="checkbox"  name="comments[]" value="12"> <i></i>
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td>Comment Text </td>
                    <td>Comment Post </td>
                    <td>Comment By</td>
                    <td>Status </td>
                    <td>Created at</td>
                    <td class="no-link last">
                        <?= Html::a('<i class="fa fa-check" aria-hidden="true"></i>', ['comment/rejected'], ['class' => 'btn btn-primary btn-xs']) ?>
                        <?= Html::a('<i class="fa fa-times" aria-hidden="true"></i>', ['comment/rejected'], ['class' => 'btn btn-danger btn-xs']) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="checkbox-container"> 
                            <input type="checkbox" name="comments[]" value="12"> <i></i>
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td>Comment Text </td>
                    <td>Comment Post </td>
                    <td>Comment By</td>
                    <td>Status </td>
                    <td>Created at</td>
                    <td class="no-link last">
                        <?= Html::a('<i class="fa fa-check" aria-hidden="true"></i>', ['comment/rejected'], ['class' => 'btn btn-primary btn-xs']) ?>
                        <?= Html::a('<i class="fa fa-times" aria-hidden="true"></i>', ['comment/rejected'], ['class' => 'btn btn-danger btn-xs']) ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
