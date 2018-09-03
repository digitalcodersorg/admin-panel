<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Branches & Departments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-index">

    
    <div class="alert btn-area">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
        <div class="clearfix"></div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action dataTable">
            <thead>
                <tr class="headings">
                    <th class="column-title">Type </th>
                    <th class="column-title">Name</th>
                    <th class="column-title">Head</th>
                    <th class="column-title">Updated On</th>
                    <th class="column-title no-link last"><span class="nobr">Action</span>
                    </th>
                   
                </tr>
            </thead>

            <tbody>
                <?php foreach ($departments as $department){?>
                <tr>
                    <td><?= $department['type'];?></td>
                    <td><?= $department['name'];?></td>
                    <td><?= $department['department_head_name'];?></td>
                    <td><?= $department['updated_on'];?></td>
                    <td><?= Html::a(Yii::t('app', '<i class="fa fa-pencil" aria-hidden="true"></i>'), ['update','id'=>$department['ID']], ['class' => '']) ?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
