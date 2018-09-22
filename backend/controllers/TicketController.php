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
use yii\filters\AccessControl;
use yii\helpers\Url;
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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

    public function actionCreate() {
        if (Yii::$app->user->can('create-ticket')) {
            throw new ForbiddenHttpException;
        }
        $model = new Ticket();
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            
            $ticket = $model->insertTicket($post);
            if($ticket){
               return $this->redirect(['ticket/view?id='.$ticket]); 
            }
        }
        return $this->render('create', [
                    'model' => $model,
                    'current_user' => Yii::$app->user->identity->id,
                    'branch' => Department::find()->select(['ID', 'name'])->where(['status' => 'Active', 'parent' => NULL])->createCommand()->queryAll(),
        ]); 
    }

    public function actionTicketlist() {
        if (!Yii::$app->user->can('view-tickets')) {
            throw new ForbiddenHttpException;
        }
        $role = '';
        if (Yii::$app->user->can('assign-ticket')) {
            $role = 'assigner';
        }
        if (Yii::$app->user->can('is-admin')) {
            $role = 'admin';
        }
        $q = Yii::$app->request->queryParams;
        $branch = isset($q['branch']) ? $q['branch'] : '';
        $departments = [];
        if (!empty($branch)) {
            $departments = Department::find()->select(['ID', 'name'])->where(['parent' => $branch])->createCommand()->queryAll();
        }
        $users = isset($q['department']) ? User::getUserByDepartment($q['department']) : [];
        $tickets = Ticket::search(Yii::$app->request->queryParams, '', $role, Yii::$app->user->identity->id);
        $branches = Department::find()->select(['ID', 'name'])->where(['status' => 'Active', 'parent' => NULL])->createCommand()->queryAll();
        return $this->render('ticketlist', [
                    'tickets' => $tickets['data'],
                    'tickets_count' => Ticket::search(Yii::$app->request->queryParams, 'count', $role, Yii::$app->user->identity->id),
                    'pages' => $tickets['pagination'],
                    'branches' => $branches,
                    'departments' => $departments,
                    'users' => $users,
                    'role' => $role,
                    'q' => Yii::$app->request->queryParams,
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
        
        $ticket = Ticket::searchOne($id);
   
        if (empty($ticket)) {
            throw new NotFoundHttpException;
        }
        if (($ticket['ticket_status'] == 'Open' && $ticket['assigned_to'] == Yii::$app->user->identity->id) || ($ticket['ticket_status'] == 'Forward' && $ticket['forwarded_to'] == Yii::$app->user->identity->id)) {
            $ticketUpdate = Ticket::findOne($id);
            $ticketUpdate->status_updated_on = date('Y-m-d H:i:s');
            $ticketUpdate->updated_on = date('Y-m-d H:i:s');
            $ticketUpdate->ticket_status = 'Inprocess';
            $ticketUpdate->save();
            $ticket['data'][0]['ticket_status'] = 'Inprocess';
            $ticket['data'][0]['updated_on'] = date('Y-m-d H:i:s');
            $ticket['data'][0]['status_updated_on'] = date('Y-m-d H:i:s');
        }

        $userData = User::find()->where(['id' => $ticket['ticket_owener']])->asArray()->one();
        $userAddress = UserAddress::getUserAddress('', $ticket['ticket_owener']);
        $ticketActivity = TicketActivity::getActivities($id);
        return $this->render('view', [
                    'ticket' => $ticket,
                    'user' => $userData,
                    'ticketActivity' => $ticketActivity,
                    'userAddress' => !empty($userAddress) ? $userAddress : [],
                    'branch' => Department::find()->select(['ID', 'name'])->where(['status' => 'Active', 'parent' => NULL])->createCommand()->queryAll(),
        ]);
    }

    public function actionAssignTicket() {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            if (Ticket::assignTicket($post)) {
                return 1;
            }
        }
        return 0;
    }

    public function actionUpdate() {
        if (!Yii::$app->user->can('update-tickets')) {
            return json_encode(['error' => 'Access Denied!']);
        }
        if (Yii::$app->request->post()) {
            $postValues = Yii::$app->request->post();
            return Ticket::updateTicket($postValues, Yii::$app->user->identity->id, Yii::$app->user->identity->username);
        } else {
            return json_encode(['Accept Only Post Request']);
        }
    }

    public function actionDashboard() {
        return $this->render('dashboard', [
                    'model' => '',
        ]);
    }

}
