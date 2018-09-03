<?php

use yii\helpers\Url;
?>
<div class="col-md-3 left_col menu_fixed">
<!--    <div id="mCSB_1" class="mCustomScrollBox mCS-minimal mCSB_vertical mCSB_outside" style="max-height: none;" tabindex="0"><div id="mCSB_1_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px;" dir="ltr">-->

            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="/" class="site_title"><i class="fa fa-users"></i> <span>Admin Panel 1.0</span></a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="<?= Url::to(['/']) ?>images/user.jpg" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span><?= Yii::t('app', 'Welcome') ?>,</span>
                        <h2><?= Yii::$app->user->identity->username;?></h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- /menu prile quick info -->

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <?php
                        //echo $controller = Yii::$app->controller->id;
                        //print_r(Yii::$app->request->get('post_type')); 
                        ?>
                        <?=
                        \yiister\gentelella\widgets\Menu::widget(
                                [
                                    "items" => [
                                        ["label" => Yii::t('app', "Dashboard"), "url" => Url::to(['/']), "icon" => "dashboard"],
                                        [
                                            "label" => Yii::t('app', "Users & Roles"),
                                            "icon" => "users",
                                            "url" => "#",
                                            'visible' => Yii::$app->user->can('view-user'),
                                            "items" => [
                                                ["label" => Yii::t('app', "User List"), "url" => Url::to(['/user'])],
                                                ["label" => Yii::t('app', "Roles"), "url" => Url::to(['/role'])],
                                            ],
                                        ],
                                        ["label" => Yii::t('app', "Branchs & Departments"), "url" => Url::to(['/department']), "icon" => "briefcase",'visible' => Yii::$app->user->can('view-department'),],
                                        [
                                            "label" => Yii::t('app', "E-Commerce"),
                                            "icon" => "shopping-bag",
                                            "url" => "#",
                                            'visible' => Yii::$app->user->can('view-ecom'),
                                            "items" => [
                                                ["label" => Yii::t('app', "Products"), "url" => Url::to(['/products'])],
                                                ["label" => Yii::t('app', "Orders"), "url" => Url::to(['/orders'])],
                                                ["label" => Yii::t('app', "Settings"), "url" => Url::to(['ecommerce/settings'])],
                                            ],
                                        ],
                                        [
                                            "label" => Yii::t('app', "CMS"),
                                            "icon" => "columns",
                                            "url" => "#",
                                            'visible' => Yii::$app->user->can('view-cms'),
                                            "items" => [
                                                ["label" => Yii::t('app', "CMS Dashboard"), "url" => Url::to(['cms/dashboard'])],
                                                ["label" => Yii::t('app', "Pages"), "url" => Url::to(['/post', 'post_type' => 'page']), 'active' => false],
                                                ["label" => Yii::t('app', "Posts"), "url" => Url::to(['/post', 'post_type' => 'posts'])],
                                                ["label" => Yii::t('app', "Comments"), "url" => Url::to(['post/comment-list'])],
                                            ],
                                        ],
                                        [
                                            "label" => Yii::t('app', "CRM"),
                                            "icon" => "bar-chart",
                                            "url" => "#",
                                            'visible' => Yii::$app->user->can('view-crm'),
                                            "items" => [
                                                ["label" => Yii::t('app', "CRM Dashboard"), "url" => Url::to(['/crm'])],
                                                ["label" => Yii::t('app', "Customer List"), "url" => Url::to(['/customers'])],
                                                ["label" => Yii::t('app', "Supplier List"), "url" => Url::to(['/suppiler'])],
                                            ],
                                        ],
                                        ["label" => Yii::t('app', "Tickets"),
                                            "icon" => "ticket",
                                            'visible' => Yii::$app->user->can('view-tickets'),
                                            "url" => Url::to(['/tickets'])],
                                        ["label" => Yii::t('app', "Customer Information"),
                                            "icon" => "id-card",
                                            'visible' => Yii::$app->user->can('view-customer-info'),
                                            "url" => Url::to(['user/customer-info'])],
                                    /*
                                      [
                                      "label" => "Badges",
                                      "url" => "#",
                                      "icon" => "table",
                                      "items" => [
                                      [
                                      "label" => "Default",
                                      "url" => "#",
                                      "badge" => "123",
                                      ],
                                      [
                                      "label" => "Success",
                                      "url" => "#",
                                      "badge" => "new",
                                      "badgeOptions" => ["class" => "label-success"],
                                      ],
                                      [
                                      "label" => "Danger",
                                      "url" => "#",
                                      "badge" => "!",
                                      "badgeOptions" => ["class" => "label-danger"],
                                      ],
                                      ],
                                      ],
                                      [
                                      "label" => "Multilevel",
                                      "url" => "#",
                                      "icon" => "table",
                                      "items" => [
                                      [
                                      "label" => "Second level 1",
                                      "url" => "#",
                                      ],
                                      [
                                      "label" => "Second level 2",
                                      "url" => "#",
                                      "items" => [
                                      [
                                      "label" => "Third level 1",
                                      "url" => "#",
                                      ],
                                      [
                                      "label" => "Third level 2",
                                      "url" => "#",
                                      ],
                                      ],
                                      ],
                                      ],
                                      ], */
                                    ],
                                ]
                        )
                        ?>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" href="<?= Url::to(['logout']) ?>" data-placement="top" data-method="post" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
<!--        </div>
    </div>-->
</div>