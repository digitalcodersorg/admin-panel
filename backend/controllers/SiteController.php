<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use common\models\Subscription;
use common\models\Ticket;
use common\models\EmailNotification;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['changepasswords', 'changepasswords'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['resetpassword', 'resetpassword'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['forgotpassword', 'forgotpassword'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $subscription_count['all'] = Subscription::getCounts('','count');
        $subscription_count['active'] = Subscription::getCounts('Active','count');
        $subscription_count['suspend'] = Subscription::getCounts('Suspend','count');
        $role = '';
        if (Yii::$app->user->can('assign-ticket')) {
            $role = 'assigner';
        }
        if (Yii::$app->user->can('is-admin')) {
            $role = 'admin';
        }
        
        $tickets_count['all'] = Ticket::search(['status'=>''],'count',$role, Yii::$app->user->identity->id);
        $tickets_count['open'] = Ticket::search(['status'=>'Open'],'count',$role, Yii::$app->user->identity->id);
        $tickets_count['closed'] = Ticket::search(['status'=>'Closed'],'count',$role, Yii::$app->user->identity->id);
        $tickets_count['resolved'] = Ticket::search(['status'=>'Resolve'],'count',$role, Yii::$app->user->identity->id);
        $tickets_count['inprocess'] = Ticket::search(['status'=>'Inprocess'],'count',$role, Yii::$app->user->identity->id);
        ///echo date('Y-m-d',strtotime("first day of this month"));
        $user_count['all'] = User::getCount('', 'count');
        $user_count['this_month'] = User::getCount(date('Y-m-d',strtotime("first day of this month")), 'count');
        return $this->render('index',[
            'subscription' => $subscription_count, 
            'tickets_count' => $tickets_count, 
            'user_count' => $user_count, 
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('dashboard');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    /*     * *******************************************************
     *       Forgot Password                           Starts *
     * ******************************************************** */

    public function actionForgotpassword() {
        if (!empty(Yii::$app->request->post())) {
            $userModel = new User();
            $userDetail = $userModel->getUserDetailByEmailId(Yii::$app->request->post()['emailId']);
            if (!empty($userDetail)) {
            $email = EmailNotification::addEmailToSend([
                'to_emails'=>array($userDetail['email'] => $userDetail['username']),
                'to_name'=>$userDetail['username'],
                'subject'=>'Reset Password ',
                'email_body'=>json_encode([
                    'userName' => $userDetail['username'],
                    'userResetToken' => $userDetail['password_reset_token'],
                    'userEmail' => $userDetail['email'],
                ]),
                'template_name'=>'forgot_password',
                'created_by'=>$userDetail['id'],
            ]);
            return ($email) ? json_encode('Password reset link sent to your registered email id.') : json_encode('Internal Error');
                
            } else {
                return json_encode('Invalid email id.');
            }
        } else {
            return $this->render("forgotpassword");
        }
    }

    public function actionResetpassword($email, $re) {
        return $this->render("new_password", ['email' => $email, 're' => $re]);
    }

    public function actionChangepasswords() {
        if (!empty(Yii::$app->request->post())) {
            $userModel = new User();
            $postValues = Yii::$app->request->post();
            $updatePassword = $userModel->updatePassword($postValues['email'], $postValues['re'], $postValues['password']);
            return $updatePassword;
        }
    }

    /*     * *******************************************************
     *       Forgot Password                           Starts *
     * ******************************************************** */

    /*     * *******************************************************
     *       Error Exception                           Starts *
     * ******************************************************** */

    public function actionError() {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
}
