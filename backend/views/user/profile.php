<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profile';
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>User Report <small>Activity report</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <div class="profile_img">
                        <div id="crop-avatar">
                            <!-- Current avatar -->
                            <img class="img-responsive avatar-view" src="images/picture.jpg" alt="Avatar" title="Change the avatar">
                        </div>
                    </div>
                    <h3>Samuel Doe</h3>

                    <ul class="list-unstyled user_data">
                        <li><i class="fa fa-map-marker user-profile-icon"></i> San Francisco, California, USA
                        </li>

                        <li>
                            <i class="fa fa-briefcase user-profile-icon"></i> Software Engineer
                        </li>

                        <li class="m-top-xs">
                            <i class="fa fa-external-link user-profile-icon"></i>
                            <a href="http://www.kimlabs.com/profile/" target="_blank">www.kimlabs.com</a>
                        </li>
                    </ul>

                    <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
                    <br>

                    <!-- start skills -->
                    <h4>Skills</h4>
                    <ul class="list-unstyled user_data">
                        <li>
                            <p>Web Applications</p>
                            <div class="progress progress_sm">
                                <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 50%;"></div>
                            </div>
                        </li>
                        <li>
                            <p>Website Design</p>
                            <div class="progress progress_sm">
                                <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="70" aria-valuenow="69" style="width: 70%;"></div>
                            </div>
                        </li>
                        <li>
                            <p>Automation &amp; Testing</p>
                            <div class="progress progress_sm">
                                <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="30" aria-valuenow="29" style="width: 30%;"></div>
                            </div>
                        </li>
                        <li>
                            <p>UI / UX</p>
                            <div class="progress progress_sm">
                                <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 50%;"></div>
                            </div>
                        </li>
                    </ul>
                    <!-- end of skills -->

                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">

                    <div class="profile_title">
                        <div class="col-md-6">
                            <h2>User Activity Report</h2>
                        </div>
                        <div class="col-md-6">
                            <div id="reportrange" class="pull-right" style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span>September 28, 2015 - November 1, 2015</span> <b class="caret"></b>
                            </div>
                        </div>
                    </div>
                    <!-- start of user-activity-graph -->
                    <div id="graph_bar" style="width: 100%; height: 280px; position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><svg height="280" version="1.1" width="755" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative; left: -0.25px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël @@VERSION</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="42.84375" y="213.11439601237498" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4.005021012374982" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><path fill="none" stroke="#aaaaaa" d="M55.34375,213.11439601237498H730" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="42.84375" y="166.08579700928124" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4.007672009281237" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">750</tspan></text><path fill="none" stroke="#aaaaaa" d="M55.34375,166.08579700928124H730" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="42.84375" y="119.05719800618749" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4.010323006187491" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">1,500</tspan></text><path fill="none" stroke="#aaaaaa" d="M55.34375,119.05719800618749H730" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="42.84375" y="72.02859900309375" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4.0129740030937455" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2,250</tspan></text><path fill="none" stroke="#aaaaaa" d="M55.34375,72.02859900309375H730" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="42.84375" y="25" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">3,000</tspan></text><path fill="none" stroke="#aaaaaa" d="M55.34375,25H730" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="696.2671875" y="225.61439601237498" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(0.8192,-0.5736,0.5736,0.8192,-16.1003,455.0738)"><tspan dy="4.005021012374982" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Other</tspan></text><text x="628.8015625" y="225.61439601237498" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(0.8192,-0.5736,0.5736,0.8192,-49.2934,430.7237)"><tspan dy="4.005021012374982" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">iPhone 6S Plus</tspan></text><text x="561.3359375" y="225.61439601237498" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(0.8192,-0.5736,0.5736,0.8192,-50.5694,384.3805)"><tspan dy="4.005021012374982" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">iPhone 6S</tspan></text><text x="493.8703125" y="225.61439601237498" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(0.8192,-0.5736,0.5736,0.8192,-70.4172,351.0414)"><tspan dy="4.005021012374982" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">iPhone 6 Plus</tspan></text><text x="426.4046875" y="225.61439601237498" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(0.8192,-0.5736,0.5736,0.8192,-71.7957,304.8685)"><tspan dy="4.005021012374982" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">iPhone 6</tspan></text><text x="358.9390625" y="225.61439601237498" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(0.8192,-0.5736,0.5736,0.8192,-87.1714,268.294)"><tspan dy="4.005021012374982" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">iPhone 5S</tspan></text><text x="291.4734375" y="225.61439601237498" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(0.8192,-0.5736,0.5736,0.8192,-96.1961,227.4805)"><tspan dy="4.005021012374982" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">iPhone 5</tspan></text><text x="224.0078125" y="225.61439601237498" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(0.8192,-0.5736,0.5736,0.8192,-115.3965,193.5678)"><tspan dy="4.005021012374982" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">iPhone 3GS</tspan></text><text x="156.5421875" y="225.61439601237498" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(0.8192,-0.5736,0.5736,0.8192,-123.7761,152.1986)"><tspan dy="4.005021012374982" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">iPhone 4S</tspan></text><text x="89.0765625" y="225.61439601237498" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(0.8192,-0.5736,0.5736,0.8192,-132.8008,111.385)"><tspan dy="4.005021012374982" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">iPhone 4</tspan></text><rect x="63.776953125" y="189.28657251747416" width="50.599218750000006" height="23.827823494900827" rx="0" ry="0" fill="#26b99a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="131.242578125" y="172.04275288300644" width="50.599218750000006" height="41.07164312936854" rx="0" ry="0" fill="#26b99a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="198.708203125" y="195.87057637790727" width="50.599218750000006" height="17.243819634467712" rx="0" ry="0" fill="#26b99a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="266.173828125" y="114.60515730056127" width="50.599218750000006" height="98.50923871181371" rx="0" ry="0" fill="#26b99a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="333.639453125" y="172.04275288300644" width="50.599218750000006" height="41.07164312936854" rx="0" ry="0" fill="#26b99a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="401.105078125" y="78.04825967548973" width="50.599218750000006" height="135.06613633688525" rx="0" ry="0" fill="#26b99a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="468.570703125" y="141.38010633298933" width="50.599218750000006" height="71.73428967938565" rx="0" ry="0" fill="#26b99a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="536.0363281250001" y="64.44131836392793" width="50.599218750000006" height="148.67307764844705" rx="0" ry="0" fill="#26b99a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="603.501953125" y="120.87563716764045" width="50.599218750000006" height="92.23875884473453" rx="0" ry="0" fill="#26b99a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="670.967578125" y="127.14611703471961" width="50.599218750000006" height="85.96827897765537" rx="0" ry="0" fill="#26b99a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect></svg><div class="morris-hover morris-default-style" style="left: 37.0766px; top: 111px; display: none;"><div class="morris-hover-row-label">iPhone 4</div><div class="morris-hover-point" style="color: #26B99A">
                                Geekbench:
                                380
                            </div></div></div>
                    <!-- end of user-activity-graph -->

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Recent Activity</a>
                            </li>
                            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Projects Worked on</a>
                            </li>
                            <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Profile</a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                                <!-- start recent activity -->
                                <ul class="messages">
                                    <li>
                                        <img src="images/img.jpg" class="avatar" alt="Avatar">
                                        <div class="message_date">
                                            <h3 class="date text-info">24</h3>
                                            <p class="month">May</p>
                                        </div>
                                        <div class="message_wrapper">
                                            <h4 class="heading">Desmond Davison</h4>
                                            <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                            <br>
                                            <p class="url">
                                                <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                                <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="images/img.jpg" class="avatar" alt="Avatar">
                                        <div class="message_date">
                                            <h3 class="date text-error">21</h3>
                                            <p class="month">May</p>
                                        </div>
                                        <div class="message_wrapper">
                                            <h4 class="heading">Brian Michaels</h4>
                                            <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                            <br>
                                            <p class="url">
                                                <span class="fs1" aria-hidden="true" data-icon=""></span>
                                                <a href="#" data-original-title="">Download</a>
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="images/img.jpg" class="avatar" alt="Avatar">
                                        <div class="message_date">
                                            <h3 class="date text-info">24</h3>
                                            <p class="month">May</p>
                                        </div>
                                        <div class="message_wrapper">
                                            <h4 class="heading">Desmond Davison</h4>
                                            <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                            <br>
                                            <p class="url">
                                                <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                                <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <img src="images/img.jpg" class="avatar" alt="Avatar">
                                        <div class="message_date">
                                            <h3 class="date text-error">21</h3>
                                            <p class="month">May</p>
                                        </div>
                                        <div class="message_wrapper">
                                            <h4 class="heading">Brian Michaels</h4>
                                            <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                            <br>
                                            <p class="url">
                                                <span class="fs1" aria-hidden="true" data-icon=""></span>
                                                <a href="#" data-original-title="">Download</a>
                                            </p>
                                        </div>
                                    </li>

                                </ul>
                                <!-- end recent activity -->

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                                <!-- start user projects -->
                                <table class="data table table-striped no-margin">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Project Name</th>
                                            <th>Client Company</th>
                                            <th class="hidden-phone">Hours Spent</th>
                                            <th>Contribution</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>New Company Takeover Review</td>
                                            <td>Deveint Inc</td>
                                            <td class="hidden-phone">18</td>
                                            <td class="vertical-align-mid">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-success" data-transitiongoal="35" aria-valuenow="35" style="width: 35%;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>New Partner Contracts Consultanci</td>
                                            <td>Deveint Inc</td>
                                            <td class="hidden-phone">13</td>
                                            <td class="vertical-align-mid">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-danger" data-transitiongoal="15" aria-valuenow="15" style="width: 15%;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Partners and Inverstors report</td>
                                            <td>Deveint Inc</td>
                                            <td class="hidden-phone">30</td>
                                            <td class="vertical-align-mid">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-success" data-transitiongoal="45" aria-valuenow="45" style="width: 45%;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>New Company Takeover Review</td>
                                            <td>Deveint Inc</td>
                                            <td class="hidden-phone">28</td>
                                            <td class="vertical-align-mid">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-success" data-transitiongoal="75" aria-valuenow="75" style="width: 75%;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- end user projects -->

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui
                                    photo booth letterpress, commodo enim craft beer mlkshk </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>