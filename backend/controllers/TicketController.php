<?php

namespace backend\controllers;

use Yii;
use common\models\Ticket;
use common\models\TicketActivity;
use common\models\Department;
use common\models\User;
use common\models\UserAddress;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class TicketController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex() {
        return $this->render('index', []);
    }
    public function actionTicketlist() {
        
        $q = Yii::$app->request->queryParams;
        $branch = isset($q['branch']) ?  $q['branch'] : '';
        $departments = [];
        if(!empty($branch)){
            $departments = Department::find()->select(['ID','name'])->where(['parent'=>$branch])->createCommand()->queryAll();  
        }
        $users = isset($q['department']) ? User::getUserByDepartment($q['department']) : [];
        $tickets = Ticket::search(Yii::$app->request->queryParams);
        $branches = Department::find()->select(['ID','name'])->where(['status'=>'Active','parent'=>NULL])->createCommand()->queryAll();
        return $this->render('ticketlist', [
            'tickets'=>$tickets['data'],
            'tickets_count'=>Ticket::search(Yii::$app->request->queryParams,'count'),
            'pages'=>$tickets['pagination'],
            'branches'=>$branches,
            'departments'=>$departments,
            'users'=>$users,
            'q'=>Yii::$app->request->queryParams,
                ]);
    }
    public function actionCustomers() {
        return $this->render('customers', []);
    }
    public function actionSuppiler() {
        return $this->render('supplier', []);
    }

    /**
     * Displays a single Post model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        if (!empty($id)) {
            if (!Yii::$app->user->can('view-tickets')) {
                throw new ForbiddenHttpException;
            }
        } else {
                throw new NotFoundHttpException;
        }
        
        $ticket = Ticket::search(['id'=>$id]);
        
        if(empty($ticket['data'])){
            throw new NotFoundHttpException;
        }
        
        $userData = User::find()->where(['id'=>$ticket['data'][0]['created_by']])->asArray()->one();
        $userAddress = UserAddress::getUserAddress('',$ticket['data'][0]['created_by']);
        $ticketActivity = TicketActivity::find()->where(['ticket_id'=>$id])->asArray()->all();
        return $this->render('view', [
                'ticket'=>$ticket['data'][0],   
                'user'=>$userData,   
                'ticketActivity'=>$ticketActivity,   
                'userAddress'=>!empty($userAddress) ? $userAddress : [],   
                'branch'=>Department::find()->select(['ID','name'])->where(['status'=>'Active','parent'=>NULL])->createCommand()->queryAll(),   
        ]);
    }
    public function actionUpdate() {
         if (!Yii::$app->user->can('update-tickets')) {
                return json_encode(['Invalid request']);
            }
        if(Yii::$app->request->post()){
           $postValues = Yii::$app->request->post();
           $activity = new TicketActivity();
           if(!empty($postValues['ticket_id'] && !empty($postValues['reply-text']))){
               $ticket = Ticket::findOne($postValues['ticket_id']);
               if(empty($ticket)){
                   return json_encode(['Invalid request']);
               }
               $ticket->ticket_priority = $postValues['ticket_priority'];
               $type = '';
               if($postValues['ticket_status'] == "Forward"){
                   $ticket->ticket_status = "Forward";
                   $ticket->department_id = $postValues['depart'];
                   $ticket->forwarded_to = $postValues['user'];
                   $ticket->status_updated_on = date('Y-m-d H:i:s');
                   $userb = User::find()->select(['id','username','email'])->where(['id'=>$postValues['user']])->one();
                   $activityMessage = ($postValues['reply-to-user'] == 'yes') ? Yii::$app->user->identity->username." forwarded this ticket to ".$userb->username." with reply to user." : \Yii::$app->user->identity->username." forwarded this ticket to ".$userb->username." with note.";
                   $type = ($postValues['reply-to-user'] == 'yes') ? "response" : "forward";
               }else{
                   $ticket->ticket_status = $postValues['ticket_status'];
                   $activityMessage = ($postValues['reply-to-user'] == 'yes') ? Yii::$app->user->identity->username." replied to customer." : Yii::$app->user->identity->username." posted a note.";
                   $type = ($postValues['reply-to-user'] == 'yes') ? "response" : "note";
               }
               $ticket->updated_on = date('Y-m-d H:i:s');
               $ticket->updated_by = Yii::$app->user->identity->id;
               if($ticket->validate()){
                   $ticket->save();
               }else{
                   return json_encode(['Invalid request']);
               }
               
               $activity = $activity->insertActivity(Yii::$app->user->identity->id,$ticket->ID,$postValues['reply-text'],$activityMessage,$ticket->ticket_status,$ticket->ticket_priority,$type);
               $activity->toArray(); 
              return json_encode(['subject'=>$activity->subject,'text'=>$activity->text,'status'=>$activity->status,'priority'=>$activity->priority,'type'=>$activity->type,'created_by'=>Yii::$app->user->identity->username,'created_on'=>$activity->created_on]);  
           } 
        }
        return json_encode(['Invalid request']);
    }
    public function actionDashboard() {
        return $this->render('dashboard', [
                    'model' => '',
        ]);
    }

}
