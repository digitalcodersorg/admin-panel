<?php

namespace backend\controllers;

use Yii;
use common\models\Department;
use common\models\UserAddress;
use common\models\User;
use backend\models\DepartmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Utility;
use yii\filters\AccessControl;
/**
 * DepartmentController implements the CRUD actions for Department model.
 */
class DepartmentController extends Controller {

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
     * Lists all Department models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new DepartmentSearch();
        $data = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'departments' => $data,
        ]);
    }

    /**
     * Displays a single Department model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionView($id) {
//        return $this->render('view', [
//                    'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new Department model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate() {
//        $model = new Department();
//        $addressModel = new UserAddress();
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->ID]);
//        }
//
//        return $this->render('create', [
//                    'model' => $model,
//                    'addressModel' => $addressModel,
//        ]);
//    }

    /**
     * Updates an existing Department model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id = '') {
        if (!empty($id)) {
            if (!Yii::$app->user->can('update-department')) {
                throw new ForbiddenHttpException;
            }
        } else {
            if (!Yii::$app->user->can('create-department')) {
                throw new ForbiddenHttpException;
            }
        }
        $utility = new Utility();
        $departmentModel = new Department();
        $addressModel = new UserAddress();
        $branches = Department::find()->select(['ID','name'])->where(['type'=>'Branch'])->createCommand()->queryAll();
        $users = User::find()->select(['id','username'])->where(['type'=>'cms_user','status'=>'Active'])->createCommand()->queryAll();
        $userList =!empty($users) ? array_column($users, 'username','id') : [];
        $branchList =!empty($branches) ? array_column($branches, 'name','ID') : [];
        
        $leftListBox = $departmentModel->getUserLeftListBoxData();
        $rightListBox = [];
        if (!empty($id)) {
            $model = $this->findModel($id);
            if (!empty($model->address)) {
                $addressModel = $addressModel->findOne($model->address);
            }
            $rightListBox = $departmentModel->getUserRightListBoxData($id);
            $model->updated_on = date('Y-m-d H:i:s');
        } else {
            $model = new Department();
            $model->created_by = Yii::$app->user->identity->id;
        }


        if ($model->load(Yii::$app->request->post())) {
            $postValues = Yii::$app->request->post();
            if ($addressModel->load(Yii::$app->request->post()) && !empty($postValues['UserAddress']['address_line1']) && !empty($postValues['UserAddress']['state'])) {
                $addressModel->user_id = NULL;
                $addressModel->title = "Branch Address";
                $addressModel->type = "Office Address";
                $addressModel->save();
            }
            $model->address = $addressModel->ID;
            $model->updated_by = Yii::$app->user->identity->id;
            
            if ($model->validate() && $model->save()) {
                if (!empty($postValues['ListBox'])) {
                    $departmentModel->deletePreviousList($model->ID);
                    $postValues['ListBox'] = array_values(array_unique($postValues['ListBox']));
                    foreach ($postValues['ListBox'] as $list) {
                        $departmentModel->insertListBoxValues($model->ID, $list, Yii::$app->user->identity->id);
                    }
                } else {
                    $departmentModel->deletePreviousList($model->ID);
                }

                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                            'model' => $model,
                            'addressModel' => $addressModel,
                            'id' => $id,
                            'leftListBox' => $leftListBox,
                            'rightListBox' => $rightListBox,
                            'userList' => $userList,
                            'branchList' => $branchList,
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'addressModel' => $addressModel,
                        'id' => $id,
                        'leftListBox' => $leftListBox,
                        'rightListBox' => $rightListBox,
                        'userList' => $userList,
                        'branchList' => $branchList,
            ]);
        }
    }

    /**
     * Deletes an existing Department model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Department model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Department the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Department::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionGetDepartment($bid){
        if(empty($bid)){
            return json_encode(['data not found']);
        }
        return json_encode(Department::find()->select(['ID','name'])->where(['parent'=>$bid])->asArray()->all());
    }

}
