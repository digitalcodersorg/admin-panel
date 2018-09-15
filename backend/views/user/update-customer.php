<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\AuthItem;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Update User';
$this->params['breadcrumbs'][] = Html::encode($this->title);
$sub_status = ['Active', 'Pause', 'Suspend', 'On Hold', 'Expired', 'Renewed', 'Cancelled'];
//echo json_encode(['product_title'=>'PC AMC 1','product_price'=>2321,'product_id'=>1232]);
?>
<div class="row">
    <!--    <div class="col-md-12">
            <div class="alert alert-success" role="alert">
                <strong>Success <span class="message">Data saved successfully!</span></strong>
            </div>
        </div>-->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-user" aria-hidden="true"></i>  <?= $model->username; ?>   </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                    </li>

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(["id" => "update-user", 'options' => ['enctype' => 'multipart/form-data'],]); ?>
                <?= $form->field($model, 'id')->hiddenInput(['value' => $model->id])->label(false) ?>
                <div class="col-md-6 form-group">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readOnly' => ($model->scenario == 'update') ? "readonly" : ""]) ?>
                </div>
                <div class="col-md-6 form-group">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>


                <div class="col-md-6 form-group">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-6 form-group">
                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6 form-group">
                    <?= $form->field($model, 'gender')->dropDownList(['male' => 'Male', 'female' => 'Female', 'other' => 'Other',], ['prompt' => 'Gender']) ?>
                </div>

                <div class="col-md-6 form-group">
                    <?= $form->field($model, 'date_of_birth')->textInput(['class' => 'form-control calender',]) ?>
                </div>

                <div class="col-md-6 form-group">
                    <?= $form->field($model, 'cms_user_contact_no')->textInput(['maxlength' => true])->label('Primary Contact No.') ?>
                </div>


                <div class="col-md-6 form-group">
                    <?= $form->field($model, 'status')->dropDownList(['Active' => 'Active', 'Inactive' => 'Inactive',], ['prompt' => 'Select Status']) ?> 
                </div>
                <div class="row">
                    <div class="branch-address col-md-12">
                        <?php echo $this->render('../widgets/_addressForm', ['form' => $form, 'addressModel' => $billing, 'label' => "Billing Address", 'size' => 6, 'minimize' => true, 'no' => 1]); ?>

                        <?php echo $this->render('../widgets/_addressForm', ['form' => $form, 'addressModel' => $shipping, 'label' => "Shipping Address", 'size' => 6, 'minimize' => true, 'no' => 2]); ?>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <span class="btn btn-primary" id="save-user-data">Save</span>
                    <a class="btn btn-primary" href="">Back</a>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="row x_title">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h2><i class="fa fa-address-card-o" aria-hidden="true"></i> Customer Personal Data</h2>
                </div>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display:none" >
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="input-group">
                        <select id="add-cuetomer-info" class="form-control" name="">
                            <option value="">Add Customer Personal Information</option>
                            <option value="User IDs">User IDs</option>
                            <option value="Password of Router">Password of Router</option>
                            <option value="Switches">Switches</option>
                            <option value="Tally information">Tally information</option>
                            <option value="Busy Information">Busy Information</option>
                            <option value="Server User Id and Password">Server User Id & Password</option>
                            <option value="Sharing Drive Data">Sharing Drive Data</option>
                            <option value="Sharing Access">Sharing Access</option>
                            <option value="Network Router Access">Network Router Access</option>
                            <option value="Access Control">Access Control</option>
                            <option value="Non AMC Products">Non AMC Products</option>
                        </select> 
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary" id="add-data-field">Add</button>
                        </span>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <button class="btn btn-primary" id="update-user-personal-data">Update Detail</button>
                    <span class="error-summary hide">Data Cannot be saved without update.</span>
                </div>
                <div class="clearfix"></div>
                <?php $form = ActiveForm::begin(["id" => "update-user-data", 'options' => ['enctype' => 'multipart/form-data'],]); ?>
                <?= $form->field($model, 'user_id')->hiddenInput(['value' => $model->id])->label(false) ?>
                <div class="" id="data-fields">

                    <?php
                    if (!empty($personal_data)) {
                        $i = 0;
                        foreach ($personal_data as $data) {
                            ?>
                            <div class="form-group col-md-6 col-sm-12 col-xs-12 meta-data" id="<?= strtolower(str_replace(' ', '_', $data['meta_key'])) ?>">
                                <label class="control-label col-md-12 col-xs-12"><?= $data['meta_key'] ?> 
                                    <small class="btn btn-danger btn-sm remove-data" data-id="<?= strtolower(str_replace(' ', '_', $data['meta_key'])) ?>">x</small>
                                </label> 
                                <input type="hidden" class="meta_key" name="personl_data[<?= $i ?>][meta_key]" value="<?= $data['meta_key'] ?>"/>
                                <textarea class="form-control" class="meta_val" rows="5" name="personl_data[<?= $i ?>][meta_value]"><?= $data['meta_value'] ?></textarea>
                            </div>
                            <?php
                            $i++;
                        }
                    }
                    ?>

                    <div class="form-group col-md-6 col-sm-12 col-xs-12 hide" id="data-template">
                        <label class="control-label col-md-12 col-xs-12"><span class="temp-label">Label</span>
                            <small class="btn btn-danger btn-sm remove-data" data-id="">x</small>
                        </label> 
                        <input type="hidden" class="meta_key" name="" value=""/>
                        <textarea class="form-control" class="meta_val" rows="5" name=""></textarea>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <?php if (!empty($subscriptions)) { ?>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="row x_title">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <h2><i class="fa fa-laptop" aria-hidden="true"></i> Customer AMC Data</h2>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <h2 class="col-md-12 col-xs-12 text-right"><?= count($subscriptions); ?> AMC Subscribed</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="row x_content">

                    <div class="col-xs-3">
                        <!-- required for floating -->
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs tabs-left">
                            <?php $true = true;
                            foreach ($subscriptions as $subscription) { ?>
        <?php $product = json_decode($subscription['product_detail'], true); ?>
                                <li class="<?= ($true) ? 'active' : '' ?>">
                                    <a data-amc="<?= $subscription['ID'] ?>" class="fetch-amc"><?= $product['product_title'] ?> (#<?= $subscription['subscription_numebr'] ?>)</a>
                                </li>
        <?php $true = false;
    } ?>
                        </ul>
                    </div>

                    <div class="col-xs-9" id="amc-info">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_10">
                                <div class="row">
    <?php $form = ActiveForm::begin(); ?>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label>Subscription Start Date</label>
                                            <input type="text" name="sub_start" value="<?= date_format(date_create($subscriptions[0]['start_date']), "Y-m-d H:i") ?>" class="form-control FrDate"/>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label>Subscription End Date</label>
                                            <input type="text" name="sub_end" value="<?= date_format(date_create($subscriptions[0]['end_date']), "Y-m-d H:i") ?>" class="form-control ToDate"/>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label>Status</label>
                                            <select name="status" id="amc_status" class="form-control">
                                                <?php foreach ($sub_status as $status) { ?>
                                                    <option value="<?= $status ?>" <?= ($status == $subscriptions[0]['status']) ? 'selected' : '' ?>><?= $status ?></option>
                                        <?php } ?>
                                            </select>
                                        </div>
                                    <?php //echo $this->render('../widgets/_addressForm', ['form' => $form, 'addressModel' => $billing, 'label' => "AMC Address", 'size' => 12, 'minimize' => true, 'no' => 3]); ?>
                                    </div>
    <?php ActiveForm::end(); ?>
                                </div>
                                <div class="row">
                                    <button class="btn btn-primary" id="add-pc-info"  data-amc="<?= $subscriptions[0]['ID']?>">
                                        <span>Add Device Information</span> 
                                        <span data-toggle="tooltip" data-placement="right" title="Add upto 10 Devices"><i class="fa fa-info-circle"></i></span>
                                    </button>
                                    <button class="btn btn-primary load-item-data">Load Device Data</button>
                                    <div class="table-responsive hide">
                                        <table class="table table-striped jambo_table bulk_action itemTable" style="width:100%;">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="column-title">Type </th>
                                                    <th class="column-title">Name</th>
                                                    <th class="column-title">Serial No</th>
                                                    <th class="column-title">Quantity</th>
                                                    <!--<th class="column-title">MAC</th>-->
                                                    <th class="column-title no-link last"><span class="nobr">Action</span>
                                                    </th>

                                                </tr>
                                            </thead>

                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--                        <div class="tab-pane" id="tab_11">Profile Tab.</div>
                                                    <div class="tab-pane" id="tab_12">Messages Tab.</div>
                                                    <div class="tab-pane" id="tab_13">Settings Tab.</div>-->
                        </div>
                    </div>

                    <div class="clearfix"></div>

                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="pc-info-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title col-md-8" id="exampleModalLabel">Device Information</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="device-form">
                            <input type="hidden" name="subcription_id" value="" id="device-form-amc-no"/>
                            <input type="hidden" name="ID" value="" class="reset" id="device-form-item-id"/>
                            <input type="hidden" name="user_id" value="<?= Yii::$app->user->identity->id; ?>"/>
                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <label for="type">Device Type</label>
                                <select name="type" id="type" class="form-control required-input reset">
                                    <option value="">Select Device Type</option>
                                    <option value="Laptop">Laptop</option>
                                    <option value="Desktop">Desktop</option>
                                    <option value="Printer">Printer</option>
                                    <option value="Printer AIO">Printer AIO</option>
                                    <option value="Modem">Modem</option>
                                    <option value="Router">Router</option>
                                    <option value="Switch">Switch</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <label for="SubscriptionItem[name]">Device Name</label>
                                <input type="text" id="name" name="name" class="form-control required-input reset" />
                            </div>
                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <label for="name">Serial no/Service Tag no.</label>
                                <input type="text" id="serial" name="serial_no" class="form-control required-input reset" />
                            </div>
                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <label for="name">Quantity</label>
                                <input type="number" id="quantity" name="quantity" class="form-control required-input reset" />
                            </div>
                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <label for="mac-address-lan">MAC Address Lan (Optional)</label>
                                <input type="text" id="mac-address-lan" name="mac_lan" class="form-control reset" />
                            </div>
                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <label for="mac-address-wifi">MAC Address Wifi (Optional)</label>
                                <input type="text" id="mac-address-wifi" name="mac_wifi" class="form-control reset" />
                            </div>
                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <label for="owener">Owener Name (Optional)</label>
                                <input type="text" id="owener" name="owener" class="form-control reset" />
                            </div>
                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <label for="desk">Desk No. (Optional)</label>
                                <input type="text" id="desk" name="desk" class="form-control reset" />
                            </div>
                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <label for="contact">Phone (Optional)</label>
                                <input type="text" id="contact" name="phone" class="form-control reset" />
                            </div>
                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                <label for="email">Email (Optional)</label>
                                <input type="text" id="email" name="email" class="form-control reset" />
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary save-sub-item">Save</button>
                        <button class="btn btn-primary reset-sub-item">Reset</button>
                        <button class="btn btn-primary" data-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>
<?php } ?>


</div>



