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
?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <strong>Holy guacamole!</strong> Best check yo self, you're not looking too good.
        </div>
    </div>
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
                    <?php $form = ActiveForm::begin(["id" => "create-user", 'options' => ['enctype' => 'multipart/form-data'],]); ?>
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
               
                <div class="branch-address">
<?php echo $this->render('../widgets/_addressForm', ['form' => $form, 'addressModel' => $billing, 'label' => "Billing Address", 'size' => 6]); ?>
                </div>
                <div class="branch-address">
                <?php echo $this->render('../widgets/_addressForm', ['form' => $form, 'addressModel' => $shipping, 'label' => "Shipping Address", 'size' => 6]); ?>
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
                            <option value="Server User Id & Password">Server User Id & Password</option>
                            <option value="Sharing Drive Data">Sharing Drive Data</option>
                            <option value="Sharing Access">Sharing Access</option>
                            <option value="Network Router Access">Network Router Access</option>
                            <option value="Access Control">Access Control</option>
                            <option value="Non AMC Products">Non AMC Products</option>
                        </select> 
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary">Add</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="row x_title">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h2><i class="fa fa-laptop" aria-hidden="true"></i> Customer AMC Data</h2>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h2 class="col-md-12 col-xs-12 text-right">4 AMC Subscribed</h2>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row x_content">

                <div class="col-xs-3">
                    <!-- required for floating -->
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tabs-left">
                        <li class="active"><a data-amc="10" class="fetch-amc">PC AMC - 1 (#10)</a>
                        </li>
                        <li class=""><a data-amc="11" class="fetch-amc">PC AMC - 2 (#11)</a>
                        </li>
                        <li class=""><a data-amc="12" class="fetch-amc">PC AMC - 3 (#2342)</a>
                        </li>
                        <li class=""><a data-amc="13" class="fetch-amc">PC AMC - 30 (#34324)</a>
                        </li>
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
                                        <input type="text" name="sub_start" value="" class="form-control FrDate"/>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                        <label>Subscription End Date</label>
                                        <input type="text" name="sub_end" value="" class="form-control ToDate"/>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                        <label>Status</label>
                                        <select name="" class="form-control">
                                            <option value="Active">Active</option>
                                            <option value="Pause">Pause</option>
                                            <option value="Sudpend">Suspend</option>
                                            <option value="On Hold">On Hold</option>
                                            <option value="On Hold">Cancelled</option>
                                            <option value="Expire">Expired</option>
                                            <option value="Renewed">Renewed</option>
                                        </select>
                                    </div>
                                <?php echo $this->render('../widgets/_addressForm', ['form' => $form, 'addressModel' => $billing, 'label' => "AMC Address", 'size' => 12, 'minimize' => true]); ?>
                                </div>
<?php ActiveForm::end(); ?>
                            </div>
                            <div class="row">
                                <button class="btn btn-primary" id="add-pc-info"  data-amc="10">
                                    <span>Add Device Information</span> 
                                    <span data-toggle="tooltip" data-placement="right" title="Add upto 10 Devices"><i class="fa fa-info-circle"></i></span>
                                </button>
                                <div class="table-responsive hide">
                                    <table class="table table-striped jambo_table bulk_action">
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
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(); ?>

<?php ActiveForm::end(); ?>
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
                    <input type="hidden" name="amc-no" value="" id="device-form-amc-no"/>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label for="type">Device Type</label>
                        <select name="type" id="type" class="form-control">
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
                        <label for="name">Device Name</label>
                        <input type="text" id="name" name="name" class="form-control" />
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label for="name">Serial no/Service Tag no.</label>
                        <input type="text" id="serial" name="serial" class="form-control" />
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label for="name">Quantity</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" />
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label for="mac-address-lan">MAC Address Lan (Optional)</label>
                        <input type="text" id="mac-address-lan" name="mac-address-lan" class="form-control" />
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label for="mac-address-wifi">MAC Address Wifi (Optional)</label>
                        <input type="text" id="mac-address-wifi" name="mac-address-wifi" class="form-control" />
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label for="owener">Owener Name (Optional)</label>
                        <input type="text" id="owener" name="owener" class="form-control" />
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label for="desk">Desk No. (Optional)</label>
                        <input type="text" id="desk" name="desk" class="form-control" />
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label for="contact">Phone (Optional)</label>
                        <input type="text" id="contact" name="contact" class="form-control" />
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-xs-12">
                        <label for="email">Email (Optional)</label>
                        <input type="text" id="email" name="email" class="form-control" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Save</button>
                <button class="btn btn-primary" data-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>