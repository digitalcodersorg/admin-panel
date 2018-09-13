<?php
/* @var $this yii\web\View */
$this->title = 'Dashboard';
//echo '<pre>';
//print_r($user_count);
//echo '</pre>';
?>
<div class="row top_tiles">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-cart-plus" aria-hidden="true"></i></div>
            <div class="count"><?= $subscription['all']; ?></div>
            <h3>Subscriptions</h3>
            <p><?= $subscription['active']; ?> Active / <?= $subscription['suspend']; ?> Suspended</p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-ticket" aria-hidden="true"></i></div>
            <div class="count"><?= $tickets_count['all'] ?></div>
            <h3>Tickets</h3>
            <p><?= $tickets_count['closed'] ?> Closed / <?= $tickets_count['resolved'] ?> Resolved / <?= $tickets_count['open'] ?> Open </p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-users" aria-hidden="true"></i></div>
            <div class="count"><?= $user_count['all'] ?></div>
            <h3>Customers</h3>
            <p><?= $user_count['this_month'] ?> Users Registered This Month</p>
        </div>
    </div>
    <!--    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-star-half-o" aria-hidden="true"></i></div>
                <div class="count">0</div>
                <h3>Products Reviews</h3>
                <p>Lorem ipsum psdea itgum rixt.</p>
            </div>
        </div>-->
</div>
<div class="row">
    <div class="col-md-12">
        <div id="dashboard-chart"></div>
    </div>
</div>
<div class="row" style="margin-top:20px;">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel" style="padding: 10px 5px;">
            <div class="x_title">
                <h2>My Todo List <small id="todo-save"></small> </h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="">
                    <input type="hidden" name="uid" id="uid" value="<?= Yii::$app->user->identity->id; ?>" />
                    <ul class="to_do">

                        <li>
                            <div class="input-group todo-item" style="width: 100%;">
                                <span class="input-group-addon">
<!--                                    <label class="control-label no-lr-padding">
                                        <div class="form-check text-right">
                                            <label>
                                                <input type="checkbox" class="todo-check"> <span class="label-text"></span>                                             </label>
                                        </div>
                                    </label>-->
                                </span>
                                <input type="text" name="" value="" maxlength="70" data-user="<?= Yii::$app->user->identity->id; ?>" data-id="" class="form-control todo-text" style="padding-left: 10px;" placeholder="Write something to remember..."/>
<!--                                <span class="todo-delete">
                                    <button class="btn btn-danger" type="button">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </button>
                                </span>-->
                            </div>
                        </li>

                        <li class="todo-template hide">
                            <div class="input-group todo-item">
                                <span class="input-group-addon">
                                    <label class="control-label no-lr-padding">
                                        <div class="form-check text-right">
                                            <label>
                                                <input type="checkbox" class="todo-check"> <span class="label-text"></span>                                             </label>
                                        </div>
                                    </label>
                                </span>
                                <input type="text" name="text" value="" maxlength="70" data-user="<?= Yii::$app->user->identity->id; ?>" data-id="" class="form-control todo-text to-do-update"/>
                                <input type="hidden" value=""/>
                                <span class="todo-delete" data-id="">
                                    <button class="btn btn-danger" type="button">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </button>
                                </span>
                            </div>
                        </li>
                    </ul>
                    <div class="row text-right">
                        <div class="col-md-12">
                        <button class="btn btn-primary btn-sm load-todo">Load older notes...</button>
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

