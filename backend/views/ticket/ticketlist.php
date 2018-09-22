<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Total Tickets : '.$tickets_count);
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
            <?php if($role == 'admin' ){?>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $b = isset($q['branch']) ? $q['branch'] : '' ?>
                <select class="form-control search-filter" id="branch_list" data-target="depart_list" name="branch">
                    <option value="">Filter By Branch</option>
                    <?php foreach ($branches as $branch) { ?>
                        <option value="<?= $branch['ID'] ?>" <?= ($b == $branch['ID']) ? 'selected' : ''; ?>><?= $branch['name'] ?></option>
<?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $d = isset($q['department']) ? $q['department'] : '' ?>
                <select class="form-control search-filter" id="depart_list" data-target="user_list" name="department">
                    <option value="">Filter By Deprtment</option>
                    <?php foreach ($departments as $department) { ?>
                        <option value="<?= $department['ID'] ?>" <?= ($d == $department['ID']) ? 'selected' : ''; ?>><?= $department['name'] ?></option>
<?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $u = isset($q['user']) ? $q['user'] : '' ?>
                <select class="form-control search-filter" id="user_list" name="user">
                    <option value="">Filter By User</option>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?= $user['id'] ?>" <?= ($u == $user['id']) ? 'selected' : ''; ?>><?= $user['username'] ?></option>
<?php } ?>
                </select>
            </div>
            <?php }?>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $s = isset($q['status']) ? $q['status'] : '' ?>
                <select class="form-control search-filter" name="status">
                    <option value="">Filter By Status</option>
                    <?php foreach ($status as $k => $v) { ?>
                        <option value="<?= $k ?>" <?= ($k == $s) ? 'selected' : ''; ?>><?= $v ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $p = isset($q['priority']) ? $q['priority'] : '' ?>
                <select class="form-control search-filter" name="priority">
                    <option value="">Filter By Priority</option>
                    <?php foreach ($priority as $k => $v) { ?>
                        <option value="<?= $k ?>" <?= ($k == $p) ? 'selected' : ''; ?>><?= $v ?></option>
            <?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $s = isset($q['subject']) ? $q['subject'] : '' ?>
                <select class="form-control search-filter" name="subject">
                    <option value="">Filter By Subject</option>
                    <?php foreach ($ticket_subjects as $k => $v) { ?>
                        <option value="<?= $k ?>" <?= ($k == $s) ? 'selected' : ''; ?>><?= $v ?></option>
            <?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <?php $c = isset($q['category']) ? $q['category'] : '' ?>
                <select class="form-control search-filter" name="category">
                    <option value="">Filter By Category</option>
                    <option value="AMC" <?= ($c == 'AMC') ? 'selected' : ''?>>AMC</option>
                    <option value="NON AMC" <?= ($c == 'NON AMC') ? 'selected' : ''?>>NON AMC</option>
                </select>
            </div>
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary btn-sm']) ?>
        
            <?php if ($role == 'assigner') { ?>
            <?php $tf = isset($q['tickets_filter']) ? $q['tickets_filter'] : '' ?>
            <button class="btn btn-primary btn-sm filter-ticket <?= ($tf == 'my') ? 'active' : ''?>" onclick="javascript:void(0)" data-target="my-tickets" data-filter="my">My Tickets</button>
            <input type="hidden" name="tickets_filter" value="<?= $tf?>" id="my-tickets"/>
            <?php }?>
            <?php $rr = isset($q['reponse']) ? $q['reponse'] : '' ?>
            <button class="btn btn-primary btn-sm filter-ticket <?= ($rr == 'true') ? 'active' : ''?>" onclick="javascript:void(0)" data-target="response-received" data-filter="true"><i class="fa fa-comments" aria-hidden="true"></i></button>
            <input type="hidden" name="reponse" value="<?= $rr?>" id="response-received"/>
            <?php if($role == 'admin' ){?>
            <button class="btn btn-primary btn-sm">Download <i class="fa fa-arrow-down" aria-hidden="true"></i></button>
            <?php }?>
            <?= Html::a(Yii::t('app', 'Clear'), ['/tickets'], ['class' => 'btn btn-primary btn-sm']); ?>
            <?= Html::a(Yii::t('app', 'Create New'), ['ticket/create'], ['class' => 'btn btn-primary btn-sm']); ?>
        </form>

        <div class="clearfix"></div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action ticket_list">
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
                <tr id="ticket_<?= $ticket['ticket_code']?>" data-code="<?= $ticket['ticket_code']?>" data-url="<?= Url::to(['ticket/view','id'=>$ticket['ID']])?>" data-action="<?= ($ticket['assigned_to_name'] == "") ? "assign_ticket" : 'view-ticket';?>" data-role="<?= $role?>" class="view-ticket <?= ($ticket['notify'] == 'unseen') ? 'response' : '' ?>" style="cursor:pointer">
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
                    <td id="deart_<?= $ticket['ticket_code']?>"><?= empty($ticket['department_name']) ? 'N/A' : mb_strimwidth($ticket['department_name'], 0,20,'..')?></td>
                    <td id="assign_<?= $ticket['ticket_code']?>"><?= ($ticket['assigned_to_name'] == "") ? "N/A" : $ticket['assigned_to_name'];?></td>
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

<div class="modal fade" id="assign-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title col-md-8" id="exampleModalCenterTitle">Assign Ticket : <span id="modal_ticket_code"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="create_ticket_form">
              <input type="hidden" name="ticket_code" id="ticket_code" value=""/>
              <input type="hidden" name="assigned_by"  value="<?= Yii::$app->user->identity->id;?>"/>
              <div class="form-group">
                   <select class="form-control branch_list" id="branch_list" data-target="depart_list_assign" name="branch">
                    <option value="">Select Branch</option>
                    <?php foreach ($branches as $branch) { ?>
                        <option value="<?= $branch['ID'] ?>"><?= $branch['name'] ?></option>
                    <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <select class="form-control depart_list" id="depart_list_assign" data-target="user_list_assign" name="department">
                    <option value="">Select Deprtment</option>
                    <?php foreach ($departments as $department) { ?>
                        <option value="<?= $department['ID'] ?>"><?= $department['name'] ?></option>
<?php } ?>
                </select>
            </div>
            <div class="form-group">
                 <select class="form-control user_list" id="user_list_assign" name="user">
                    <option value="">Select User</option>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
<?php } ?>
                </select>
            </div>
              <div class="form-group">
                  <label for="reply-text" class="control-label col-md-8 col-sm-8 col-xs-12 no-lr-padding">Comments
                        </label>

                        <textarea rows="7" id="reply-text" name="reply-text" class="form-control"></textarea>
                        <label class="control-label no-lr-padding">
                            <div class="form-check text-right">
                                <label>
                                    <input type="hidden" name="reply-to-user" id="reply-to-user" value="no">
                                    <input type="checkbox" class="reply-type"> <span class="label-text"></span>                                        <span class="checkbox-text">
                                        Reply to user
                                        <span data-toggle="tooltip" data-placement="right" title="" data-original-title="Reply visible to user"><i class="fa fa-info-circle"></i></span>
                                    </span> 

                                </label>
                            </div>
                        </label
              </div>
          </form>
      </div>
      
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary create-ticket">Assign</button>
        <button type="button" class="btn btn-primary open-ticket" data-url="">View Ticket</button>
      </div>
  </div>
</div>
</div>