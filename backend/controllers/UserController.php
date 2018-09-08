<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\Utility;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use common\models\AuthAssignment;
use common\models\UserAddress;
use common\models\Country;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\data\Pagination;
use common\models\Subscription;
use common\models\SubscriptionItem;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        if (!Yii::$app->user->can('view-user')) {
            throw new ForbiddenHttpException;
        }
        $user = new User();

        return $this->render('index', [
                    'users' => $user->search(Yii::$app->request->queryParams),
                    'username' => isset(Yii::$app->request->queryParams['username']) ? Yii::$app->request->queryParams['username'] : "",
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate() {
//        $model = new User();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('create', [
//                    'model' => $model,
//        ]);
//    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id = '') {
        if (!empty($id)) {
            if (!Yii::$app->user->can('update-user')) {
                throw new ForbiddenHttpException;
            }
        } else {
            if (!Yii::$app->user->can('create-user')) {
                throw new ForbiddenHttpException;
            }
        }
        $model = new User();
        $utility = new Utility();
        $user_level_array = [];
        $model->scenario = 'create';

        if (!empty($id)) {
            $model->scenario = 'update';
            $model = User::findOne($id);
            if (empty($model)) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            $user_level_array = [];
            $modelAuth = AuthAssignment::find()->select('item_name')->where('user_id = :user_id', [':user_id' => $id])->all();
            $listData = ArrayHelper::map($modelAuth, 'item_name', 'item_name');
            $model->role = $listData;
        }
        if ($model->load(Yii::$app->request->post())) {
            $postValues = Yii::$app->request->post();
            if (empty($id)) {
                $emailPassword = $postValues['User']['password_hash'];
            }
// If password is not blank
            if (!empty($model->password_hash) && !empty($model->confirm_password)) {

                if ($model->password_hash == $model->confirm_password) {
                    $model->setPassword($model->password_hash);
                    $model->generateAuthKey($model->auth_key);
                    $model->confirm_password = $model->password_hash;
                }
            }

            if (!empty($_FILES['User']['name']['cms_user_avatar'])) {

                $file_detail = UploadedFile::getInstance($model, 'cms_user_avatar');
                $file_url = $utility->uploadFiles($file_detail->name, $file_detail->tempName);
                if (!empty($file_url)) {
                    $model->cms_user_avatar = $file_url;
                }
            } else if (!empty($postValues['cms_user_avatar'])) {
                $model->cms_user_avatar = $postValues['cms_user_avatar'];
            } else {
                $model->cms_user_avatar = '';
            }
            if (empty($id)) {
                $model->created_at = new Expression('NOW()');
            }
            $model->updated_at = new Expression('NOW()');

// If password is blank
            if (empty($model->password_hash) && !empty($id)) {
                $modelUpdated = User::findOne($id);
                $model->confirm_password = $modelUpdated->password_hash;
                $model->password_hash = $modelUpdated->password_hash;
            }
            if ($model->validate()) {
                if (empty($id)) {
                    $model->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
                }
                $model->role = '';
                if (!empty($postValues['User']['role'])) {
                    $model->role = $postValues['User']['role'];
                }


                if ($model->save()) {
                    if (!empty($postValues['User']['role'])) {
                        $roles = $postValues['User']['role'];
                        $modelAuth = new AuthAssignment();
                        AuthAssignment::deleteAll('user_id = :user_id', [':user_id' => $model->id]);
                        foreach ($roles as $role) {
                            $modelAuth->setIsNewRecord(true);
                            $modelAuth->user_id = $model->id;
                            $modelAuth->item_name = $role;
                            $modelAuth->save();
                        }
                    }
                }

                if (empty($id)) {
                    $email_body = [
                        'userPassword' => $emailPassword,
                        'userName' => $model->username,
                        'creatorName' => Yii::$app->user->identity->username,
                    ];

//                    EmailNotification::addEmailToSend(array($model->email => $model->username), $model->username, \Yii::$app->params['supportEmail'], \Yii::$app->params['supportName'], 'Twitter Seva: Email Confirmation', json_encode($email_body), 'user_created', $created_by = Yii::$app->user->identity->username, $cc = null, $bcc = null);
                }

                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                            'model' => $model,
                            'id' => $id,
                            'user_level' => $user_level_array
                ]);
            }
        }
        return $this->render('update', [
                    'model' => $model,
                    'id' => $id,
                    'user_level' => $user_level_array
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionDelete($id) {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    public function actionProfile() {
        return $this->render('profile');
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCustomerInfo() {
        if (!Yii::$app->user->can('view-customer-info')) {
            throw new ForbiddenHttpException;
        }
        $user = new User();
        $pages = new Pagination(['totalCount' => 2]);
        return $this->render('customer-list', [
                    'users' => $user->search(Yii::$app->request->queryParams, 'frontend_user'),
                    'username' => isset(Yii::$app->request->queryParams['username']) ? Yii::$app->request->queryParams['username'] : "",
                    'pages' => $pages,
        ]);
    }

    public function actionViewCustomer() {
        if (!Yii::$app->user->can('view-customer-info')) {
            throw new ForbiddenHttpException;
        }
        $user = new User();
        return $this->render('view-customer', [
                    'users' => $user->search(Yii::$app->request->queryParams, 'frontend_user'),
                    'username' => isset(Yii::$app->request->queryParams['username']) ? Yii::$app->request->queryParams['username'] : "",
        ]);
    }

    public function actionUpdateCustomer($user = "") {
        if (!Yii::$app->user->can('update-customer-info')) {
            throw new ForbiddenHttpException;
        }

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $model = User::findOne($post['User']['id']);
            if (isset($post['UserAddress'][1]['ID'])) {
                $defaultShipping = UserAddress::findOne($post['UserAddress'][2]['ID']);
            } else {
                $defaultShipping = new UserAddress();
                $defaultShipping->user_id = $post['User']['id'];
                $defaultShipping->type = 'default_shipping';
            }
            if (isset($post['UserAddress'][2]['ID'])) {
                $defaultBilling = UserAddress::findOne($post['UserAddress'][1]['ID']);
            } else {
                $defaultBilling = new UserAddress();
                $defaultBilling->user_id = $post['User']['id'];
                $defaultBilling->type = 'default_billing';
            }
            $defaultShipping->attributes = $post['UserAddress'][2];
            $defaultShipping->save();
            $defaultBilling->attributes = $post['UserAddress'][1];
            $defaultBilling->save();
            $model->confirm_password = $model->password_hash;
            $model->attributes = $post['User'];
            if ($model->validate()) {
                $model->save();
                return 1;
            } else {
                print_r($model->errors);
                return 0;
            }
        } else {
            $modal = User::findOne($user);
            $data = $modal->getUserMeta($user, 'USER_PERSONAL_DATA');
            $defaultShipping = UserAddress::find()->where(['type' => 'default_shipping', 'user_id' => $user])->orderBy(['ID' => SORT_DESC])->one();
            $defaultBilling = UserAddress::find()->where(['type' => 'default_billing', 'user_id' => $user])->orderBy(['ID' => SORT_DESC])->one();
            $subscriptions = Subscription::find()->where(['subscriber_id'=>$user])->asArray()->all();
            return $this->render('update-customer', [
                        'model' => $modal,
                        'subscriptions' => $subscriptions,
                        'personal_data' => !empty($data) ? json_decode($data, true) : [],
                        'shipping' => empty($defaultShipping) ? new UserAddress : $defaultShipping,
                        'billing' => empty($defaultBilling) ? new UserAddress : $defaultBilling,
            ]);
        }
    }

    public function actionGetStates($country = '') {
        if (!empty($country)) {
            return json_encode(Country::getStateList($country));
        }
        return NULL;
    }

    public function actionGetUsers($did = '') {
        if (!empty($did)) {
            return json_encode(User::getUserByDepartment($did));
        }
        return json_encode(['data not found!']);
    }
    public function actionUpdateCustomerData(){
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $user = new User();
            $data = $user->getUserMeta($post['User']['user_id'], 'USER_PERSONAL_DATA');
            if(count($data) > 0){
                $flag = $user->updateUserMeta('USER_PERSONAL_DATA', json_encode($post['personl_data']),$post['User']['user_id']);
            }else{
                $flag = $user->addUserMeta('USER_PERSONAL_DATA', json_encode($post['personl_data']),$post['User']['user_id']);
            }
            
            if($flag){
                return 1;
            }
        }
        return 0;
    }
    //Fetch Customer personal data with user_id
    public function actionGetCustomerData($uid = ''){
        if (!empty($uid)) {
            $user = new User();
            $data = $user->getUserMeta($uid, 'USER_PERSONAL_DATA');
            return json_encode($data);
        }
        return 'Invalid Request';
    }
}
