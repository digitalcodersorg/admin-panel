<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="top_nav">

    <div class="nav_menu">
        <nav class="" role="navigation">
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                <h2 class="breadcrumbs"><?= Html::encode($this->title) ?>
<?php if (Yii::$app->controller->id == 'ticket' && Yii::$app->controller->action->id == 'ticketlist') { ?>
                        <label class="control-label no-lr-padding auto-refresh-checkbox">
                            <div class="form-check text-right">
                                <label>
                                    <input type="checkbox" class="auto-refresh"> <span class="label-text"></span>                                        <span class="checkbox-text">
                                        Auto Refresh
                                        <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Page Auto Refresh in 60sec."><i class="fa fa-info-circle"></i></span>
                                    </span> 

                                </label>
                            </div>
                        </label>
<?php } ?>
                </h2>

            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?= Url::to(['/']) ?>images/user.jpg" alt=""><?= Yii::$app->user->identity->username; ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <!--                        <li><a href="javascript:;">  Profile</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="badge bg-red pull-right">50%</span>
                                                        <span>Settings</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">Help</a>
                                                </li>-->
                        <li><a href="<?= Url::to(['/logout']) ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
                <!--                <li role="presentation" class="dropdown">
                                     <a href="" class="dropdown-toggle info-number">
                                        <i class="fa fa-comment"></i>
                                        <span class="badge bg-blue">6</span>
                                    </a>
                                </li>
                                <li role="presentation" class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ticket"></i>
                                        <span class="badge bg-green">6</span>
                                    </a>
                                   <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                        <li>
                                            <a>
                                                <span class="image">
                                                    <img src="http://placehold.it/128x128" alt="Profile Image" />
                                                </span>
                                                <span>
                                                    <span>John Smith</span>
                                                    <span class="time">3 mins ago</span>
                                                </span>
                                                <span class="message">
                                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                                </span>
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <div class="text-center">
                                                <a href="<?= Url::to(['tickets']) ?>">
                                                    <strong>See All Tickets</strong>
                                                    <i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>-->
            </ul>
        </nav>
    </div>

</div>
<!-- /top navigation -->