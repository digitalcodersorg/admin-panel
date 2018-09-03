<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Tickets');
$this->params['breadcrumbs'][] = $this->title;
$status = Yii::$app->params['status'];
$priority = Yii::$app->params['priority'];
$ticket_subjects = Yii::$app->params['ticket_subjects'];
?>
<div class="post-index">

    <div class="alert btn-area">
        <form action="" class="search-form">
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <input type="text" name="search_text" value="<?= isset($q['search_text']) ? $q['search_text'] : '' ?>" class="form-control" autocomplete="off" placeholder="search in tickets"/>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <input type="text" name="ticket_from" id="FrDate" value="<?= isset($q['ticket_from']) ? $q['ticket_from'] : '' ?>" class="form-control" autocomplete="off" placeholder="From"/>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                <input type="text" name="ticket_to"  id="ToDate" value="<?= isset($q['ticket_to']) ? $q['ticket_to'] : '' ?>" class="form-control" autocomplete="off" placeholder="To"/>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $b = isset($q['branch']) ? $q['branch'] : '' ?>
                <select class="form-control" id="branch_list" data-depar="depart_list" name="branch">
                    <option value="">Filter By Branch</option>
                    <?php foreach ($branches as $branch) { ?>
                        <option value="<?= $branch['ID'] ?>" <?= ($b == $branch['ID']) ? 'selected' : ''; ?>><?= $branch['name'] ?></option>
<?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $d = isset($q['department']) ? $q['department'] : '' ?>
                <select class="form-control" id="branch_list" data-depar="user_list" name="department">
                    <option value="">Filter By Deprtment</option>
                    <?php foreach ($departments as $department) { ?>
                        <option value="<?= $department['ID'] ?>" <?= ($d == $department['ID']) ? 'selected' : ''; ?>><?= $department['name'] ?></option>
<?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $u = isset($q['user']) ? $q['user'] : '' ?>
                <select class="form-control" id="user_list" name="user">
                    <option value="">Filter By User</option>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?= $user['id'] ?>" <?= ($u == $user['id']) ? 'selected' : ''; ?>><?= $user['username'] ?></option>
<?php } ?>
                </select>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $s = isset($q['status']) ? $q['status'] : '' ?>
                <select class="form-control" name="status">
                    <option>Filter By Status</option>
                    <?php foreach ($status as $k => $v) { ?>
                        <option value="<?= $k ?>" <?= ($k == $s) ? 'selected' : ''; ?>><?= $v ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $p = isset($q['priority']) ? $q['priority'] : '' ?>
                <select class="form-control" name="priority">
                    <option>Filter By Priority</option>
                    <?php foreach ($priority as $k => $v) { ?>
                        <option value="<?= $k ?>" <?= ($k == $p) ? 'selected' : ''; ?>><?= $v ?></option>
            <?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $s = isset($q['subject']) ? $q['subject'] : '' ?>
                <select class="form-control" name="subject">
                    <option>Filter By Subject</option>
                    <?php foreach ($ticket_subjects as $k => $v) { ?>
                        <option value="<?= $k ?>" <?= ($k == $s) ? 'selected' : ''; ?>><?= $v ?></option>
            <?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $c = isset($q['category']) ? $q['category'] : '' ?>
                <select class="form-control" name="category">
                    <option>Filter By Category</option>
                    <option value="AMC" <?= ($c == 'AMC') ? 'selected' : ''?>>AMC</option>
                    <option value="NON AMC" <?= ($c == 'NON AMC') ? 'selected' : ''?>>NON AMC</option>
                </select>
            </div>
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a(Yii::t('app', 'Clear'), ['/tickets'], ['class' => 'btn btn-primary btn-sm']); ?>
            <?php if (Yii::$app->user->can('assign-ticket')) { ?>
            <?php $tf = isset($q['tickets_filter']) ? $q['tickets_filter'] : '' ?>
            <button class="btn btn-primary btn-sm filter-ticket <?= ($tf == 'my') ? 'active' : ''?>" onclick="javascript:void(0)" data-target="my-tickets" data-filter="my">My Tickets</button>
            <button class="btn btn-primary btn-sm filter-ticket <?= ($tf == 'all') ? 'active' : ''?>" onclick="javascript:void(0)" data-target="my-tickets" data-filter="all">All Tickets</button>
            <input type="hidden" name="tickets_filter" value="" id="my-tickets"/>
            <?php }?>
            <button class="btn btn-primary btn-sm">Download <i class="fa fa-arrow-down" aria-hidden="true"></i></button>
        </form>

        <div class="clearfix"></div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    
                    <th class="column-title">Priority</th>
                    <th class="column-title">Customer</th>
                    <th class="column-title">Company</th>
                    <th class="column-title">Category</th>
                    <th class="column-title" style="width: 100px;">Code</th>
                    <th class="column-title">Text</th>
                    <th class="column-title">Department</th>
                    <th class="column-title" style="width: 94px;">Assigned To</th>
                    <th class="column-title" style="width: 94px;">Created On</th>
                    <th class="column-title">Status</th>
                    <th class="column-title no-link last">
                        
                    </th>

                </tr>
            </thead>

            <tbody>
                <?php foreach ($tickets as $ticket) { ?>
                <tr data-url="<?= Url::to(['ticket/view','id'=>$ticket['ID']])?>" class="view-ticket <?= ($ticket['notify'] == 'unseen') ? 'response' : '' ?>" style="cursor:pointer">
                    <td>
                    <button class="btn btn_priority  btn_<?= strtolower($ticket['ticket_priority'])?>" title="<?= $ticket['ticket_priority']?>"><?= $ticket['ticket_priority']?></button>
                    </td>
                    <td><?= $ticket['ticket_owener_name']?></td>
                    <td><?= mb_strimwidth('Company Name', 0,10,'...')?></td>
                    <td><?= $ticket['category']?></td>
                    <td><?= $ticket['ticket_code']?></td>
                    <td>
                        <p class="ticket-subject"><strong><?= $ticket_subjects[$ticket['ticket_subject']]?></strong></p>
                        <p class="ticket-text"><?= mb_strimwidth($ticket['ticket_text'], 0,100,'...')?></p>
                    </td>
                    <td><?= empty($ticket['department_name']) ? 'N/A' : mb_strimwidth($ticket['department_name'], 0,20,'..')?></td>
                    <td><?= ($ticket['assigned_to_name'] == "") ? "N/A" : $ticket['assigned_to_name'];?></td>
                    <td><?= $ticket['created_on']?></td>
                    <td><button class="btn btn_priority btn-<?= strtolower($ticket['ticket_status'])?>" title="<?= $ticket['status_updated_on']?>"><?= $ticket['ticket_status']?></button> </td>
                    <td>
                        <?php if($ticket['notify'] == 'unseen'){?>
                        <i class="fa fa-comments" style="color: #405467;" aria-hidden="true"></i>
                    <?php }?>
                        </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="col-md-12 text-center">
            <?php
            echo LinkPager::widget([
                'pagination' => $pages,
            ]);
            ?>
        
        </div>
        
        
    </div>
</div>
