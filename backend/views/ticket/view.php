<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Ticket Code : ' . $ticket['ticket_code'];
$this->params['breadcrumbs'][] = ['label' => 'Ticket:' . $ticket['ticket_code'], 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$ticket_subjects = Yii::$app->params['ticket_subjects'];
$status = Yii::$app->params['status'];
$priority = Yii::$app->params['priority'];
//$data = [
//    'desk'=>'54 Second Row',
//    'contact-person'=>'Gaurav Kumar',
//    'pc-name'=>'PC - 5432A',
//    'contact'=>'9876543567',
//    'subscription'=>'',
//    'company'=>'Opalina Technology Pvt Ltd.',
//];
//echo '<pre>';
//print_r(json_decode($ticket['ticket_contacts'])); 
//echo '</pre>';
?>
<div class="view-ticket">
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h4> <i class="fa fa-ticket" aria-hidden="true"></i> Ticket Info 
                        <small><i class="fa fa-wrench" aria-hidden="true"></i> Assigned to: <strong><?= !empty($ticket['assigned_to_name']) ? $ticket['assigned_to_name'] : 'Not Assigned' ?></strong></small></h4>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <h2 class="ticket-subject"><?= $ticket_subjects[$ticket['ticket_subject']] ?></h2>
                    <p><?= $ticket['ticket_text'] ?></p>
                    <label class="control-label">Additional ticket information</label>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label">Department</label></td>
                                <td><?= $ticket['department_name'] ?></td>
                            </tr>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label">Ticket Created On</label></td>
                                <td><p><strong><?= date_format(date_create($ticket['created_on']), "Y-m-d H:i:s") ?></strong></p></td>
                            </tr>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label">Last Activity On</label></td>
                                <td><p><strong><?= date_format(date_create($ticket['updated_on']), "Y-m-d H:i:s") ?></strong></p></td>
                            </tr>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label">Ticket Status</label></td>
                                <td><span class="btn btn_priority btn-<?= strtolower($ticket['ticket_status']) ?>" title="<?= $ticket['status_updated_on'] ?>"><?= $ticket['ticket_status'] ?></span></td>
                            </tr>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label">Ticket Priority</label></td>
                                <td><button onclick="return false;" class="btn btn_priority btn_<?= strtolower($ticket['ticket_priority']) ?>" title="<?= $ticket['ticket_priority'] ?>"><?= $ticket['ticket_priority'] ?></button></td>
                            </tr>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label">Ticket Owener <span data-toggle="tooltip" data-placement="right" title="" data-original-title="Ticket Creator"><i class="fa fa-info-circle"></i></span></label></td>
                                <td><p><strong><?= $ticket['created_by_name'] ?></strong></p> </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_title">
                    <h4> <i class="fa fa-address-card-o" aria-hidden="true"></i> Customer Detail <small><a target="blank" href="#" title="Open Profile"><i class="fa fa-user" aria-hidden="true"></i></a></small></h4>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label">Customer Name</label></td>
                                <td><p><strong><?= $user['first_name'] ?> <?= $user['last_name'] ?> (<?= $ticket['ticket_owener_name'] ?>)</strong></p></td>
                            </tr>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label">AMC Type</label></td>
                                <td><p>Yes</p></td>
                            </tr>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label">Email</label></td>
                                <td><p><a href="mailto:<?= $user['email'] ?>"><i class="fa fa-envelope" aria-hidden="true"></i> <?= $user['email'] ?></a></p></td>
                            </tr>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label">Phone</label></td>
                                <td><p><?= empty($user['cms_user_contact_no']) ? "Not Available" : $user['cms_user_contact_no'] ?></p></td>
                            </tr>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label">Address</label></td>
                                <td>
                                    <address>
                                        <p><?= $userAddress['address_line1'] ?></p>
                                        <p><?= $userAddress['address_line2'] ?> <?= $userAddress['land_mark'] ?></p>
                                        <p><?= $userAddress['city'] ?> <?= $userAddress['state_name'] ?> <?= $userAddress['country_name'] ?> <?= $userAddress['zip'] ?></p>
                                    </address> 
                                </td>
                            </tr>
                            <?php
                            if (!empty($ticket['ticket_contacts'])) {
                                $addData = json_decode($ticket['ticket_contacts'], true);
                                ?>
                                <tr>
                                    <td><label class="control-label">Contact Person</label></td><td><?= $addData['contact-person'] ?></td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">Company</label></td><td><?= $addData['company'] ?></td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">Desk</label></td><td><?= $addData['desk'] ?></td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">PC Name</label></td><td><?= $addData['pc-name'] ?></td>
                                </tr>

<?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h4><i class="fa fa-comments-o" aria-hidden="true"></i> Ticket Activity</h4>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div class="row activity-panel">
                        <div class="activity activity-templte col-md-12 hide">
                            <div class="profile-img col-md-2 col-sm-2 col-xs-12 no-lr-padding">
                                <img class="img-responsive activity-avatar" src="<?= Url::toRoute("images/user-icon.png"); ?>" alt=""/>
                            </div>
                            <div class="activity-text col-md-10 col-sm-10 col-xs-12 no-lr-padding">

                            </div>
                        </div>

                        
                        <ul class="list-unstyled timeline widget activity-list">
                            <?php foreach ($ticketActivity as $activity) { ?>
                            <li class="]<?= $activity['type'] ?>">
                                <div class="block">
                                    <div class="block_content">
                                        <h2 class="title">
                                            <a><?= $activity['subject'] ?></a>
                                        </h2>
                                        <div class="byline">
                                            <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?= $activity['created_on'] ?></span> by <a><?= $activity['activity_by'] ?></a>
                                        </div>
                                        <p class="excerpt"><?= $activity['text'] ?>
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
<?php if (Yii::$app->user->can('edit-ticket')) { ?>
            <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h4><i class="fa fa-reply" aria-hidden="true"></i> Reply</h4>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
    <?php $form = ActiveForm::begin(['action' => 'update', "id" => "reply-form", 'options' => ['enctype' => 'multipart/form-data'],]); ?>
                        <input type="hidden" name="ticket_id" value="<?= $ticket['ID'] ?>"/>
                        <div class="form-group col-md-6 col-xs-12">
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
                            </label>
                        </div>

                        <div class="form-group col-md-6 col-xs-12" style="margin-top: 24px;">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ticket_status">Status </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control col-md-7 col-xs-12" name="ticket_status" id="ticket_status">
                                    <?php foreach ($status as $k => $v) { ?>
                                        <option value="<?= $k ?>" <?= ($k == $ticket['ticket_status']) ? 'selected' : ''; ?>><?= $v ?></option>
    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="user-select collapse" id="user-select">
                            <div class="form-group col-md-6 col-xs-12">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="depart_list">Branch </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select class="form-control col-md-7 col-xs-12 branch_list" name="branch" data-target="depart_list" id="branch">
                                        <option value="">Select Branch</option>
                                        <?php foreach ($branch as $k) { ?>
                                            <option value="<?= $k['ID'] ?>"><?= $k['name'] ?></option>
    <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-xs-12">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="depart_list">Departments </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select class="form-control col-md-7 col-xs-12 depart_list" id="depart_list" name="depart" data-target="user_list" id="depart_list">
                                        <option value="">Select Department</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6 col-xs-12">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_list">User List </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select class="form-control col-md-7 col-xs-12" name="user" id="user_list">
                                        <option value="">Select user to forward ticket</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ticket_priority">Ticket Priority </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select class="form-control col-md-7 col-xs-12" name="ticket_priority" id="ticket_priority">
                                    <?php foreach ($priority as $k => $v) { ?>
                                        <option value="<?= $k ?>" <?= ($k == $ticket['ticket_priority']) ? 'selected' : ''; ?>><?= $v ?></option>
    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!--                    <div class="form-group col-md-6 col-xs-12">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ticket_priority">Upload Files 
                                                    <span data-toggle="tooltip" data-placement="right" title="" data-original-title="Only .png, .jpeg, .pdf, .doc, .docx, .xls files are accepted"><i class="fa fa-info-circle"></i></span>
                                                </label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <input type="file" accept=".png,.jpeg,.pdf,.doc,.docx,.xls" name="document" value="" />
                                                </div>
                                            </div>-->
    <?php ActiveForm::end(); ?>
                        <div class="form-group col-md-12 col-xs-12">
                            <button class="btn btn-primary submit-reply">Submit</button>
    <?= Html::a(Yii::t('app', 'Back'), ['/tickets'], ['class' => 'btn btn-primary ']); ?>
                        </div>

                    </div>
                </div>
            </div>
<?php } ?>
    </div>
</div>
