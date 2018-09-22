<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = "Create Ticket";
$ticket_subjects = Yii::$app->params['ticket_subjects'];
?>
<div class="row x_panel user-create">
    <?php $form = ActiveForm::begin(['action' => '', "id" => "create-ticket", 'options' => ['enctype' => 'multipart/form-data'],]); ?>
        <div class="form-group col-md-4 col-xs-12">
            <label class="control-label">Customer username (Login ID)</label>
            <input type="text" value="" class="form-control search-user" placeholder="Search Customers"/>
            <input type="hidden" name="ticket_owener" value=""/>
            <input type="hidden" name="created_by" value="<?= $current_user?>"/>
            <ul class="dropdown-menu searched-text" aria-labelledby="dropdownMenu1">
                
            </ul>
        </div>
        <div class="form-group col-md-4 col-xs-12">
            <label class="control-label">Subject</label>
            <select class="form-control search-filter" name="subject">
                <option value="">Ticket Subject</option>
                <?php foreach ($ticket_subjects as $k => $v) { ?>
                    <option value="<?= $k ?>"><?= $v ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-md-4 col-xs-12">
            <label class="control-label">Priority</label>
            <select class="form-control" name="priority">
                <option value="Low" selected="">Low</option>
                <option value="Normal">Normal</option>
                <option value="High">High</option>
                <option value="Critical">Critical</option>
            </select>
        </div>
        <div class="form-group col-md-6 col-xs-12">
            <label class="control-label">Ticket Text</label>
            <textarea name="ticket_text" class="form-control"></textarea>
        </div>
    <!--        <div class="form-group col-md-6 col-xs-12">
                <label class="control-label">Comment</label>
                <textarea name="ticket_activity" class="form-control"></textarea>
            </div>-->
        <label class="col-md-12 control-label">More Information (Optional) : </label>
        <div class="form-group col-md-4 col-xs-12">
            <label class="control-label">Contact Name</label>
            <input type="text" name="ticket_contact[contact-person]" value="" class="form-control"/>
        </div>
        <div class="form-group col-md-4 col-xs-12">
            <label class="control-label">Desk</label>
            <input type="text" name="ticket_contact[desk]" value="" class="form-control"/>
        </div>
        <div class="form-group col-md-4 col-xs-12">
            <label class="control-label">PC Name</label>
            <input type="text" name="ticket_contact[pc-name]" value="" class="form-control"/>
        </div>
        <div class="form-group col-md-4 col-xs-12">
            <label class="control-label">Mobile No.</label>
            <input type="text" name="ticket_contact[contact]" value="" class="form-control"/>
        </div>
        <div class="form-group col-md-4 col-xs-12">
            <label class="control-label">Company Name</label>
            <input type="text" name="ticket_contact[company]" value="" class="form-control"/>
        </div>
        <label class="col-md-12 control-label">Assign Ticket : </label>
        <div class="form-group col-md-4 col-xs-12">
            <label class="control-label " for="depart_list">Branch </label>

            <select class="form-control branch_list" name="branch" data-target="depart_list" id="branch">
                <option value="">Select Branch</option>
                <?php foreach ($branch as $k) { ?>
                    <option value="<?= $k['ID'] ?>"><?= $k['name'] ?></option>
                <?php } ?>
            </select>

        </div>
        <div class="form-group col-md-4 col-xs-12">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="depart_list">Departments </label>

            <select class="form-control depart_list" id="depart_list" name="department_id" data-target="user_list" id="depart_list">
                <option value="">Select Department</option>
            </select>

        </div>

        <div class="form-group col-md-4 col-xs-12">
            <label class="control-label" for="user_list">User List </label>
            <select class="form-control " name="assigned_to" id="user_list">
                <option value="">Select user to forward ticket</option>
            </select>
        </div>
        <div class="form-group col-md-12 col-xs-12">
            <input type="submit" class="btn btn-primary" value="Create"/>
            <input type="reset" class="btn btn-primary" value="Reset"/>
        </div>
    <?php ActiveForm::end(); ?>
</div>