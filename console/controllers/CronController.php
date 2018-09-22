<?php

namespace console\controllers;

use Yii;
use common\models\EmailNotification;
// use console\models\Utility;
use yii\console\Controller;
use \yii\base\ErrorException;

class CronController extends Controller {
    public function actionMail(){
        echo "\nStarted at : " . date("h:i:s");
        $emails = EmailNotification::find()->where(['`status`'=>'Pending'])->limit(100)->asArray()->all();
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
                        echo "\n".$email["template_name"];
                        if (!empty($current_email_id)) {
                            $flag = Yii::$app->mailer->compose($email["template_name"], ["model" => $email])
                                    ->setFrom([(empty($email['from_email_id']) ? \Yii::$app->params['supportEmail'] : $email['from_email_id']) =>
                                        (empty($email['from_name']) ? \Yii::$app->params['supportName'] : $email['from_name'])])
                                    ->setTo($current_email_id)
                                    ->setSubject($email['subject'])
                                    ->send();
                        }
                        echo $flag;
                        echo "\nSent Email for " . $email["id"];
                    }
                } catch (ErrorException $e) {
                    echo "\nError in sending email " . $e->getTraceAsString();
                }
                sleep(1);
        }
        echo "\nEnded at : " . date("h:i:s");
        echo "\n-------------------------\n\n";
    }
}