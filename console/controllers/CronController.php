<?php

namespace console\controllers;

use Yii;
use common\models\EmailNotification;
use common\models\Utility;
use yii\console\Controller;
use \yii\base\ErrorException;
use common\models\User;
use common\models\Subscription;
use common\models\UserAddress;
class CronController extends Controller {

    public function actionMail() {
        echo "\nStarted at : " . date("h:i:s");
        $emails = EmailNotification::find()->where(['`status`' => 'Pending'])->limit(100)->asArray()->all();
        $subject_prefix = \Yii::$app->params['mail_prefix'];
        foreach ($emails as $email) {
            try {
                $to_email_id = json_decode($email["to_email_id"], true);
                $current_email_id = array();
                foreach ($to_email_id as $emailKey => $item) {

                    if (!filter_var($emailKey, FILTER_VALIDATE_EMAIL) === FALSE) {
                        $current_email_id[$emailKey] = $item;
                    } else {
                        throw new ErrorException($emailKey);
                    }
                    if (!empty($current_email_id)) {
                        $flag = Yii::$app->mailer->compose($email["template_name"], ["model" => $email])
                                ->setFrom([(empty($email['from_email_id']) ? \Yii::$app->params['supportEmail'] : $email['from_email_id']) =>
                                    (empty($email['from_name']) ? \Yii::$app->params['supportName'] : $email['from_name'])])
                                ->setTo($current_email_id)
                                ->setSubject($email['subject'])
                                ->send();
                    }
                    if ($flag) {
                        $sent = EmailNotification::findOne($email["id"]);
                        $sent->status = "Sent";
                        $sent->save();
                        echo "\nSent Email for " . $email["id"];
                    } else {
                        echo "\nEmail Not Sent for " . $email["id"];
                    }
                }
            } catch (ErrorException $e) {
                echo "\nError in sending email " . $e->getTraceAsString();
            }
            sleep(1);
        }
        echo "\nEnded at : " . date("h:i:s");
        echo "\n-------------------------\n\n";
    }

    public function actionSyncuser() {
        echo "\nStarted at : " . date("h:i:s");
        $utility = new Utility();
        $conn = $utility->getSqlConnection("localhost", "jamaeaco_vimal", "VimalAdmin!", "jamaeaco_wp722");
        //$conn = $utility->getSqlConnection("localhost", "root", "root", "japman");
        echo "\n" . 'Process Started';
        $state = [
            "" => "",
            "AP" => 248,
            "AR" => 249,
            "AS" => 250,
            "BR" => 251,
            "CT" => 253,
            "GA" => 257,
            "GJ" => 258,
            "HR" => 259,
            "HP" => 260,
            "JK" => 261,
            "JH" => 262,
            "KA" => 263,
            "KL" => 265,
            "MP" => 267,
            "MH" => 268,
            "MN" => 269,
            "ML" => 270,
            "MZ" => 271,
            "NL" => 272,
            "OR" => 275,
            "PB" => 278,
            "RJ" => 279,
            "SK" => 280,
            "TN" => 281,
            "TS" => 282,
            "TR" => 283,
            "UK" => 285,
            "UP" => 284,
            "WB" => 287,
            "AN" => 247,
            "CH" => 252,
            "DN" => 254,
            "DD" => 255,
            "DL" => 256,
            "LD" => 266,
            "PY" => 277];
        if (!isset($conn->dsn)) {
            echo "/n" . date("Y-m-d h:i:sa") . ' : ' . $conn;
        } else {
            $lastUpdate = User::find()->where(["type" => "frontend_user"])->orderBy(['updated_at' => SORT_DESC])->limit(1)->asArray()->one();
            $filter = "";
            if (!empty($lastUpdate)) {
                
                 $now = date("Y-m-d H:i:s");
                 $current = date('Y-m-d H:i:s',strtotime('+5 hour +30 minutes',strtotime($now)));
                 $last = date('Y-m-d H:i:s',strtotime('-5 hour -30 minutes',strtotime($lastUpdate['updated_at'])));
                 $timestamp = $utility->getTimestamp($last);
                echo "\n";
                
                $filter = "where ID in (select user_id from wpxp_usermeta where meta_key = 'last_update' and meta_value > " . $timestamp . " group by user_id) OR user_registered > '" . $last . "'";
            }
            echo $sql = 'select * from wpxp_users ' . $filter;
            
            $userCommand = $conn->createCommand($sql);
            $users = $userCommand->queryAll();
            foreach ($users as $u) {
                $finduser = User::find()->where(['username' => $u['user_login']])->one();
                if (isset($finduser->username)) {
                    $user = $finduser;
                } else {
                    $user = new User();
                }
                
                $userMetaCommand = $conn->createCommand('select * from wpxp_usermeta where user_id=' . $u['ID']);
                $userMeta = $userMetaCommand->queryAll();
                
                $meta = array_column($userMeta, "meta_value", "meta_key");
                $user->username = $u['user_login'];
                $user->email = $u['user_email'];
                $user->created_at = $u['user_registered'];
                $user->status = ($u['user_status'] == 0) ? "Active" : "Inactive";
                $user->first_name = isset($meta["first_name"]) ? $meta["first_name"] : "";
                $user->last_name = isset($meta["last_name"]) ? $meta["last_name"] : "";
                $user->updated_at = $current;
                $phone = isset($meta['billing_phone']) ?  $meta['billing_phone'] : "";
                $user->cms_user_contact_no = isset($meta['mobile']) ? $meta['mobile'] : $phone;
                $user->type = 'frontend_user';
                $user->created_by = 1;
                $user->updated_by = 1;
                if ($user->validate()) {
                    $user->save();
                    echo "<br> Updated " . $user->username;
                    if (isset($meta['billing_address_2']) && isset($meta['billing_address_1']) && isset($meta['billing_postcode'])) {
                        $biillinga = UserAddress::find()->where(['user_id' => $user->id, "type" => "default_billing"])->one();                  
                        $company = ($meta['billing_company']) ? $meta['billing_company'] : "";
                        if (!empty($biillinga)) {
                            $billing = $biillinga;
                            $user->updateUserMeta("Company Name", $company, $user->id);
                        } else {
                            $billing = new UserAddress();
                            $user->addUserMeta("Company Name", $company, $user->id);
                        }
                        $billing->user_id = $user->id;
                       
                        
                        $billing->title = isset($meta['billing_company']) ? $meta['billing_company'] : "";
                        $billing->address_line1 = $meta['billing_address_1'];
                        $billing->address_line2 = $meta['billing_address_2'];
                        $billing->city = isset($meta['billing_city']) ? $meta['billing_city']   : "";
                        $billing->land_mark = "";
                        $billing->type = "default_billing";
                        $billing->country = 101;
                        $billing->state = isset($state[$meta['billing_state']]) ? $state[$meta['billing_state']] : NULL;
                        $billing->zip = $meta['billing_postcode'];
                        $billing->phone_no = isset($meta['billing_phone']) ?  $meta['billing_phone'] : NULL;
                        $billing->email = isset($meta['billing_email']) ? $meta['billing_email'] : $u['user_email'];
                        $billing->save();
                    }
                    if (isset($meta['shipping_city']) && isset($meta['shipping_address_1'])) {
                        if(!empty($meta['shipping_address_1']) && !empty($meta['shipping_city'])){
                         $shippinga = UserAddress::find()->where(['user_id' => $user->id, "type" => "default_shipping"])->one();
                        if (!empty($shippinga)) {
                            $shipping = $shippinga;
                        } else {
                            $shipping = new UserAddress();
                        }
                        $shipping = new UserAddress();
                        $shipping->user_id = $user->id;
                        $shipping->title = isset($meta['shipping_company']) ? $meta['shipping_company'] : "";
                        $shipping->address_line1 = $meta['shipping_address_1'];
                        $shipping->address_line2 = $meta['shipping_address_2'];
                        $shipping->city = $meta['shipping_city'];
                        $shipping->land_mark = "";
                        $shipping->type = "default_shipping";
                        $shipping->country = 101;
                        $shipping->state = isset($state[$meta['shipping_state']]) ? $state[$meta['shipping_state']] : NULL;
                        $shipping->zip = $meta['shipping_postcode'];
                        $shipping->phone_no = isset($meta['shipping_phone']) ?  $meta['shipping_phone'] : NULL;
                        $shipping->email = isset($meta['shipping_email']) ? $meta['shipping_email'] : $u['user_email'];
                        $shipping->save();   
                        }
                    }
                }
            }
            echo "\nEnd at : " . date("h:i:s");
        }
    }

    public function actionSyncsubs() {
        echo "\nStarted at : " . date("h:i:s");
        $utility = new Utility();
        $conn = $utility->getSqlConnection("localhost", "jamaeaco_vimal", "VimalAdmin!", "jamaeaco_wp722");
        echo "\n" . 'Process Started';

        if (!isset($conn->dsn)) {
            echo "/n" . date("Y-m-d h:i:sa") . ' : ' . $conn;
        } else {
            $lastUpdate = Subscription::find()->orderBy(['updated_on' => SORT_DESC])->limit(1)->asArray()->one();

            $filter = "";
            if (!empty($lastUpdate)) {
                $last = date('Y-m-d H:i:s',strtotime('-5 hour -30 minutes',strtotime($lastUpdate['updated_on'])));
                $filter = " and post_modified > '" . $last . "'";
            }
            echo $sql = 'select * from wpxp_posts where post_type= "sumosubscriptions" ' . $filter;

            $subsCommand = $conn->createCommand($sql);
            $subs = $subsCommand->queryAll();
            
            foreach ($subs as $u) {
                $subsMetaCommand = $conn->createCommand('select * from wpxp_postmeta where post_id=' . $u['ID']);
                $subsMeta = $subsMetaCommand->queryAll();
                $meta = array_column($subsMeta, "meta_value", "meta_key");
                $findSubs = Subscription::find()->where(['subscription_numebr' => $meta['sumo_get_subscription_number']])->one();
                $now = date("Y-m-d H:i:s");
                 $current = date('Y-m-d H:i:s',strtotime('+5 hour +30 minutes',strtotime($now)));
                if (isset($findSubs->subscription_numebr)) {
                    $newSub = $findSubs;
                } else {
                    $newSub = new Subscription();
                    $newSub->subscription_numebr = isset($meta['sumo_get_subscription_number']) ? $meta['sumo_get_subscription_number'] : "";
                    $stdClassObj = preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen('stdClass') . ':"stdClass"', $meta['sumo_get_subscriber_data']);
                    $suser = unserialize($stdClassObj);
                    $suser->data->user_login;
                    $user = User::find()->where(['username'=>$suser->data->user_login])->one();
                    $newSub->subscriber_id = $user->id;
                    $newSub->created_by = $user->id;
                    $newSub->created_on = isset($u['post_date']) ? $u['post_date'] : $current;
                }
                $item = explode('-', $meta['sumo_product_name']);
                $product = unserialize($meta['sumo_subscription_product_details']);
                $newSub->status = isset($meta['sumo_get_status']) ? $meta['sumo_get_status'] : "";
                //$newSub->subscription_period = isset($meta['sumo_subscr_plan']) ? $meta['sumo_subscr_plan'] : "";
                $newSub->subscription_period = 365;
                $newSub->item_quntity = isset($item[1]) ? $item[1] : 1;
                $newSub->product_detail = '{"product_title":"'.$meta['sumo_product_name'].'","product_price":'.$product['subfee'].',"product_id":'.$product['productid'].',"order_id" : '.$meta['sumo_get_parent_order_id'].'}';
                $newSub->updated_by = 1;
                $newSub->start_date = isset($meta['sumo_get_sub_start_date']) ? $meta['sumo_get_sub_start_date'] : "";
                $newSub->end_date = isset($meta['sumo_get_next_payment_date']) ? $meta['sumo_get_next_payment_date'] : "";
                
                $newSub->updated_on = $current;
                if($newSub->validate()){
                    $newSub->save();
                }
            }
            echo "\nEnd at : " . date("h:i:s");
        }
        echo "\n-------------------------\n\n";
    }
     public function actionCloseticket() {
        echo "\nClose older tickets Started at : " . date("h:i:s");
        $connection = Yii::$app->db;
        $query = "update pnl_tickets set ticket_status='Closed' WHERE ticket_status ='Resolve' AND status_updated_on <= ( CURDATE() - INTERVAL 6 DAY )";
        $command = $connection->createCommand($query);
        $command->execute();
        echo "\nEnd at : " . date("h:i:s");
     }
}
