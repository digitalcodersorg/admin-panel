<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\AuthItem;
use common\models\User;

$userModel = new User();
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Customer Detail';
$this->params['breadcrumbs'][] = Html::encode($this->title);
$sub_status = ['Active', 'Pause', 'Suspend', 'On Hold', 'Expired', 'Renewed', 'Cancelled'];
//echo json_encode(['product_title'=>'PC AMC 1','product_price'=>2321,'product_id'=>1232]);
?>
<div class="row">
    <div class="col-md-12">
<?php echo Html::a('Edit User', ['user/update-customer', 'user' => $user['id']], ['class' => 'btn btn-sm btn-dark']); ?>
<?php echo Html::a('Back to List', ['user/customer-info'], ['class' => 'btn btn-sm btn-dark']); ?>
        
    </div>
</div>
<div class="row">
    <!--    <div class="col-md-12">
            <div class="alert alert-success" role="alert">
                <strong>Success <span class="message">Data saved successfully!</span></strong>
            </div>
        </div>-->

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-user" aria-hidden="true"></i>     <?= $user['username'] ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                    </li>

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td style="max-width: 90px;"><label class="control-label">Customer Name</label></td>
                            <td><p><strong><?= $user['first_name'] ?> <?= $user['last_name'] ?> </strong></p></td>
                        </tr>
                        <tr>
                            <td style="max-width: 90px;"><label class="control-label">AMC Type</label></td>
                            <td><p><?= ($amc) ? 'Yes' : 'No' ?></p></td>
                        </tr>
                        <tr>
                            <td style="max-width: 90px;"><label class="control-label">Company Name</label></td>
                            <td><p><?= $userModel->getUsermeta($user['id'], 'Company Name') ?></p></td>
                        </tr>
                        <tr>
                            <td style="max-width: 90px;"><label class="control-label">Email</label></td>
                            <td><p><a href="mailto:<?= $user['email'] ?>"><i class="fa fa-envelope" aria-hidden="true"></i> <?= $user['email'] ?></a></p></td>
                        </tr>
                        <tr>
                            <td style="max-width: 90px;"><label class="control-label">Phone</label></td>
                            <td><p><?= empty($user['cms_user_contact_no']) ? "Not Available" : $user['cms_user_contact_no'] ?></p></td>
                        </tr>
<?php if (!empty($defaultBilling)) { ?>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label">Billing Address</label></td>
                                <td>
                                    <address>
                                        <p><?= $defaultBilling['address_line1'] ?></p>
                                        <p><?= $defaultBilling['address_line2'] ?> <?= $defaultBilling['land_mark'] ?></p>
                                        <p><?= $defaultBilling['city'] ?> <?= $defaultBilling['state_name'] ?> <?= $defaultBilling['country_name'] ?> <?= $defaultBilling['zip'] ?></p>
                                    </address> 
                                </td>
                            </tr>
                        <?php } ?>
<?php if (!empty($defaultBilling)) { ?>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label">Shipping Address</label></td>
                                <td>
                                    <address>
                                        <p><?= $defaultShipping['address_line1'] ?></p>
                                        <p><?= $defaultShipping['address_line2'] ?> <?= $defaultShipping['land_mark'] ?></p>
                                        <p><?= $defaultShipping['city'] ?> <?= $defaultShipping['state_name'] ?> <?= $defaultShipping['country_name'] ?> <?= $defaultShipping['zip'] ?></p>
                                    </address> 
                                </td>
                            </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="row x_title">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h2><i class="fa fa-address-card-o" aria-hidden="true"></i> Customer Personal Data</h2>
                </div>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                    </li>

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-borderless">
                    <tbody>
<?php foreach ($personal_data as $data) { ?>
                            <tr>
                                <td style="max-width: 90px;"><label class="control-label"><?= $data['meta_key'] ?>  </label></td>
                                <td><p style="padding-left:5px"><?= $data['meta_value'] ?></p></td>
                            </tr>
<?php } ?>
                    </tbody>
                </table>
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
                            foreach ($subscriptions as $subscription) {
                                ?>
        <?php $product = json_decode($subscription['product_detail'], true); ?>
                                <li class="<?= ($true) ? 'active' : '' ?>">
                                    <a data-amc="<?= $subscription['ID'] ?>" class="fetch-amc"><?= $product['product_title'] ?> (#<?= $subscription['subscription_numebr'] ?>)</a>
                                </li>
        <?php $true = false;
    }
    ?>
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
    <?php //echo $this->render('../widgets/_addressForm', ['form' => $form, 'addressModel' => $billing, 'label' => "AMC Address", 'size' => 12, 'minimize' => true, 'no' => 3]);  ?>
                                    </div>
    <?php ActiveForm::end(); ?>
                                </div>
                                <div class="row">
                                    <button class="btn btn-primary" id="add-pc-info"  data-amc="<?= $subscriptions[0]['ID'] ?>">
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

