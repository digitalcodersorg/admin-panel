<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Utility;
use common\models\User;
use common\models\Todo;
use common\models\Subscription;
use common\models\SubscriptionItem;
use common\models\Ticket;
use common\models\EmailNotification;
use common\models\UserAddress;
use common\models\TicketActivity;

/**
 * Site controller
 */
class ApiController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionGetChartData($uid = '') {
        $chartData = [];
        $chartData[] = ['name' => 'Open', 'data' => Ticket::getChartData('Open'), "color" => "#cf2929"];
        $chartData[] = ['name' => 'Inprocess', 'data' => Ticket::getChartData('Inprocess'), "color" => "#21a808"];
        $chartData[] = ['name' => 'Forward', 'data' => Ticket::getChartData('Forward'), "color" => "#5bc0de"];
        $chartData[] = ['name' => 'Resolve', 'data' => Ticket::getChartData('Resolve'), "color" => "#FD6A02"];
        $chartData[] = ['name' => 'Closed', 'data' => Ticket::getChartData('Closed'), "color" => "#9E7CD7"];
        $chartData[] = ['name' => 'All', 'data' => Ticket::getChartData(''), "color" => "#000"];
        return json_encode($chartData);
    }

    public function actionInsertTicket() {
        if (Yii::$app->request->post()) {
            $ticket = new Ticket();
            $post = Yii::$app->request->post();
            if (!empty($post['username'])) {

                $user = User::find()->where(['username' => $post['username']])->asArray()->one();
                $post['ticket_owener'] = !empty($user['id']) ? $user['id'] : "";
                if (!empty($post['amc-user'])) {
                    $amcuser = User::find()->where(['username' => $post['amc-user']])->asArray()->one();
                    $post['ticket_owener'] = !empty($amcuser['id']) ? $amcuser['id'] : "";
                }
                if (!empty($user)) {
                    $post['created_by'] = $user['id'];
                    if ($ticket->insertTicket($post)) {
                        return "1";
                    }
                }
            }
        }
        return json_encode(['error' => 'Invalid Request']);
    }

    public function actionUpdateTicket() {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $activity = new TicketActivity();
            $user = User::find()->where(['username' => $post['username']])->asArray()->one();
            $ticket = Ticket::find()->where(['ID' => $post['ticket_id']])->one();
            $ticket->notify = "unseen";
            $ticket->save();
            if (!empty($user) && !empty($ticket) && !empty($post['reply-text'])) {
                $activity = $activity->insertActivity($user['id'], $ticket->ID, $post['reply-text'], $user['username'] . " replied on ticket.", $ticket->ticket_status, $ticket->ticket_priority, "response");
                $activity->toArray();
                return json_encode(['subject' => $activity->subject, 'text' => $activity->text, 'status' => $activity->status, 'priority' => $activity->priority, 'type' => $activity->type, 'created_by' => $post['username'], 'created_on' => $activity->created_on]);
            }
        }
        return json_encode(['error' => 'Invalid Request']);
    }

    public function actionGetTickets($tid = "", $uid = "", $page = 1, $limit = 1000) {
        $ticket = ['data' => []];
        if (!empty($uid)) {
            $user = User::find()->where(['username' => $uid])->asArray()->one();
        }

        if (!empty($user)) {
            $ticket = Ticket::search(['owener' => (isset($user['id']) ? $user['id'] : ""), 'id' => $tid], $action = '', 'user', $user_id = '', $limit);
        }
        $activity = [];
        if (!empty($tid)) {
            $activity = TicketActivity::getActivities($tid, "response");
            $ticket['child'] = $activity;
        }
        return json_encode($ticket);
    }

    public function actionGetSubscription() {
        $subscription = Subscription::getCounts('', '');
        return json_encode($subscription);
    }
    public function actionTest(){
        $depart = new \common\models\Department();
        $branch = $depart->findBranch(7);
        print_r($branch);die;
    }
    public function actionSyncticket() {
        echo '<pre><code>';
        echo "\nStarted at : " . date("h:i:s");
        $utility = new Utility();
        $conn = $utility->getSqlConnection("localhost", "jamaeaco_vimal", "VimalAdmin!", "jamaeaco_wp722");

        if (!isset($conn->dsn)) {
            echo "/n" . date("Y-m-d h:i:sa") . ' : ' . $conn;
        } else {

            $subjects = [
                'browser' => 1,
                'desktop' => 2,
                'general' => 3,
                'laptop' => 4,
                'misc' => 5,
                'office' => 6,
                'printer' => 7,
                'printer-aio' => 8,
                'scanner' => 9,
                'soft' => 10,
                'tablet' => 11,
                'ups' => 12,
                'wifi' => 13,
                'ports' => 14,
                'amc' => 15,
                'other' => 16,
            ];
            $users = User::find()->select('id,username')->asArray()->all();
            $user = array_column($users, "id", "username");
            $sql = 'select st.*, wu.user_login as ticket_owener , us.user_login as ticket_assign from wpxp_support_ticket st join wpxp_users wu on st.created_by = wu.ID join wpxp_users us on st.assign_to = us.ID where parant = 0';
            $ticketCommand = $conn->createCommand($sql);
            $tickets = $ticketCommand->queryAll();
            foreach ($tickets as $ticket) {

                $created_by = $user[$ticket['ticket_owener']];
                $assign_to = $user[$ticket['ticket_assign']];

                $newticket = new Ticket();
                $newticket->ticket_code = 'JT' . $ticket["ticket_code"];
                $newticket->category = ($ticket["amc"] == "NO") ? "NON AMC" : "AMC";
                $newticket->ticket_text = $ticket["ticket_text"];
                $newticket->ticket_subject = $subjects[$ticket["subject"]];
                $newticket->ticket_status = $ticket["status"];
                $newticket->ticket_priority = $ticket["priority"];
                $newticket->assigned_to = $assign_to;
                $newticket->forwarded_to = NULL;
                $newticket->department_id = 7;
                $newticket->assigned_by = $created_by;
                $newticket->created_by = $created_by;
                $newticket->updated_by = $created_by;
                $newticket->ticket_owener = $created_by;
                $newticket->ticket_contacts = '{"contact-person":"' . $ticket["employee_name"] . '","desk":"' . $ticket["desk"] . '","pc-name":"' . $ticket["computer"] . '","contact":"' . $ticket["contact"] . '","company":"' . $ticket["company_name"] . '"}';
                $newticket->notify = 'seen';
                $newticket->status_updated_on = $ticket["updated_at"];
                $newticket->updated_on = $ticket["updated_at"];
                $newticket->created_on = $ticket["created_at"];

                if ($newticket->validate()) {
                    $newticket->save();
                    $sql = 'select st.*, wu.user_login as ticket_owener from wpxp_support_ticket st join wpxp_users wu on st.created_by = wu.ID where parant = ' . $ticket["ticket_id"];
                    $activityCommand = $conn->createCommand($sql);
                    $acts = $activityCommand->queryAll();
                    foreach ($acts as $act) {
                        $activity = new TicketActivity();
                        $activity->text = $act["ticket_text"];
                        $activity->subject = $act["subject"];
                        $activity->status = $act["status"];
                        $activity->priority = $act["priority"];
                        $activity->ticket_id = $newticket->ID;
                        $activity->created_by = $user[$act["ticket_owener"]];
                        $activity->updated_by = $user[$act["ticket_owener"]];
                        $activity->created_on = $act["created_at"];
                        $activity->updated_on = $act["updated_at"];
                        $activity->save();
                    }
                }
            }
        }
        echo "\nEnd at : " . date("h:i:s");
        echo '<code><pre>';
        die;
    }

    public function actionGetItem($id = "", $sid = "") {
        if (empty($sid)) {
            return json_encode(['error' => 'Data Not Found']);
        }
        return json_encode(SubscriptionItem::getItems($id, $sid));
    }

    public function actionGetUserData($ID = "", $search = '') {
        $user = new User();
        $userData = $user->search(['username' => $search], 'frontend_user', true);
        return json_encode($userData);
    }

    public function actionUpdateUser() {
        
    }

    public function actionGetSubscriptionItem($sid = '') {
        if (!empty($sid)) {
            $subscriptionItem = SubscriptionItem::find()->where(['subcription_id' => $sid])->asArray()->all();
            return json_encode($subscriptionItem);
        }
        return json_encode(['error' => 'Invalid Request']);
    }

    public function actionAddSubscriptionItem() {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            if (!empty($post['ID'])) {
                $response = SubscriptionItem::updateItem(Yii::$app->request->post());
            } else {
                $response = SubscriptionItem::insertItem(Yii::$app->request->post());
            }
            return $response;
        }
        return json_encode(['error' => 'Invalid Request']);
    }

    public function actionDeleteSubscriptionItem() {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $delete = SubscriptionItem::deleteItem($post['ID']);
            return json_encode(['error' => $delete]);
        }
        return json_encode(['error' => 'Invalid Request']);
    }

    public function actionGetTodo($uid = '', $page = '') {
        if (!empty($uid)) {
            $data = Todo::getTodo($uid, $page);
            return json_encode(['error' => '', 'data' => $data['data'], 'total' => $data['count']]);
        }
        return json_encode(['error' => 'User ID is empty.']);
    }

    public function actionUpdateTodo() {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $flag = true;
            $id = '';
            if (!empty($post['text']) && !empty($post['ID'])) {
                $flag = Todo::updateTodo($post);
            } else {
                $id = Todo::insertTodo($post);
            }
            return json_encode(['error' => ($flag ? '0' : 'Invalid Data'), 'id' => $id]);
        }
        return json_encode(['error' => 'Invalid Request']);
    }

    public function actionDeleteTodo() {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            if (!empty($post['user']) && !empty($post['ID'])) {
                return $todo = Todo::deleteTodo($post);
            }
            return json_encode(['error' => ($todo) ? 0 : $todo]);
        }
        return json_encode(['error' => 'Invalid Request']);
    }

    public function actionUpdateSubscription() {

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            print_r($post);
            $subs = new Subscription();
            $subs->saveSubscription(['Subscription' => $post]);
        }
        return json_encode(['error' => 'Invalid Request']);
    }
    public function actionSendmail(){
         echo "\nStarted at : " . date("h:i:s");
         Yii::$app->mailer->compose()
                ->setFrom('jdeveloper.vimal@gmail.com')
                ->setTo('vimal043kumar@gmail.com')
                ->setSubject('Message subject')
                ->setTextBody('Plain text content')
                ->setHtmlBody('<b>HTML content</b>')
                ->send();
        die;
    }
}
