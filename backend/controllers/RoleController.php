<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\Department;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Utility;
use common\models\EmailNotification;
use common\models\AuthItem;
use common\models\AuthItemChild;
use common\models\AuthAssignment;
use common\models\TblAuthRule;
use common\models\Group;
use yii\web\ForbiddenHttpException;
use yii\db\Expression;
class RoleController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
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

    public function actionIndex() {
//       if (!Yii::$app->user->can('view-role')) {
//           throw new ForbiddenHttpException;
//       }
        $model = new AuthItem();
        $utility = new Utility();
        $userList = $model->search();
        if (!empty(Yii::$app->request->queryParams)) {

            $userList = $model->search(Yii::$app->request->queryParams);
        }
//        $model = AuthItem::find()->where('type = :type', [':type' => 1])->asArray()->all();

        return $this->render('index', [
                    'userList' => $userList,
                    'utility' => $utility,
        ]);
    }

    public function actionCreatepermission() {
//        if (!Yii::$app->user->can('admin')) {
//            throw new ForbiddenHttpException;
//        }
        $model = new AuthItem();
        $authRule = Group::find()->all();
        if (Yii::$app->request->post('AuthItem')) {
            $post = Yii::$app->request->post('AuthItem');
            $model->attributes = $post;
            $model->type = 2;
            if (!empty($post['name'])) {
                $model->name = AuthItem::checkItemFormat($post['name']);
            }
            if (!empty($post['group_name'])) {
                $model->group_name = $post['group_name'];
            }

            if ($model->isNewRecord) {
                $model->created_at = \Yii::$app->user->identity->id;
            }
            $model->updated_at = \Yii::$app->user->identity->id;

            if ($model->validate() && $model->save()) {

                return $this->redirect(['role/index']);
            }
        }

        return $this->render('createpermission', ['model' => $model, 'authRule' => $authRule]);
    }

    public function actionCreategroup() {
//        if (!Yii::$app->user->can('admin')) {
//            throw new ForbiddenHttpException;
//        }
        $model = new Group();
        if (Yii::$app->request->post('Group')) {
            $post = Yii::$app->request->post('Group');
            $model->attributes = $post;

            if ($model->validate() && $model->save()) {

                return $this->redirect(['role/index']);
            }
        }

        return $this->render('creategroup', ['model' => $model]);
    }

    public function actionUpdaterole($name = '') {

//        if (!Yii::$app->user->can('admin')) {
//            throw new ForbiddenHttpException;
//        } 
        $model = new AuthItem();
        $leftListBox = [];
        $leftListBox = Group::find()->select('pnl_group.name')->joinWith(['authItems'])->asArray()->all();
        $rightListBox = [];
//        echo '<pre>'; print_r($leftListBox); die;
        if (!empty($name)) {
            $model = AuthItem::find()
                    ->where('name = :name', [':name' => $name])
                    ->one();
            $rightListBox = AuthItemChild::find()->where('parent = :parent', [':parent' => $name])
                            ->asArray()->all();
        }
        if (empty($model)) {
            $model = new AuthItem();
        }
        if (Yii::$app->request->post('AuthItem')) {

            $post = Yii::$app->request->post('AuthItem');
            $listbox = Yii::$app->request->post('ListBox');

            $model->attributes = $post;
            $model->type = 1;
            if (!empty($post['name'])) {
                $model->name = AuthItem::checkItemFormat($post['name']);
            }
            if ($model->isNewRecord) {
                $model->created_at = new Expression('NOW()');
            }

            $model->updated_at = new Expression('NOW()');

            if ($model->validate()) {
                $model->save();
                if (!empty($listbox)) {
                    AuthItemChild::deleteAll('parent = :parent', [':parent' => $model->name]);
                    $authModel = new AuthItemChild();

                    foreach ($listbox as $child) {
                        $authModel->setIsNewRecord(true);
                        $authModel->parent = $model->name;
                        $authModel->child = $child;
                        $authModel->save();
                    }
                }
                return $this->redirect(['role/index']);
            } else {
            return $this->render('createrole', ['model' => $model, 'rightListBox' => $rightListBox, 'leftListBox' => $leftListBox]);
            }
        }

        return $this->render('createrole', ['model' => $model, 'rightListBox' => $rightListBox, 'leftListBox' => $leftListBox]);
    }

//	public function actionAssignrole($id = '') {
//		$user = User::find()->all();
//		$model = new AuthAssignment();
//		$leftListBox = [];
//		$leftListBox = AuthItem::find()->all();
//		$rightListBox = [];
//		if (!empty($id)) {
//
//			$model->user_id = $id;
//			$rightListBox = AuthAssignment::find()->select('item_name as child')->where('user_id = :user_id', [':user_id' => $id])
//							->asArray()->all();
//		}
//
//		if (empty($model)) {
//			$model = new AuthAssignment();
//		}
//		if (Yii::$app->request->post('AuthAssignment')) {
//			$post = Yii::$app->request->post('AuthAssignment');
//			$listbox = Yii::$app->request->post('ListBox');
//
//			if (!empty($post['user_id'])) {
//				$id = $post['user_id'];
//
//				if (!empty($listbox) && User::find()->where([ 'id' => $id])->exists()) {
//
//					AuthAssignment::deleteAll('user_id = :user_id', [':user_id' => $id]);
//
//
//					foreach ($listbox as $child) {
//						$model->setIsNewRecord(true);
//						$model->user_id = $id;
//						$model->item_name = $child;
//						$model->save();
//					}
//					return $this->redirect(array('role/assignrole', 'id' => $id));
//				}
//			}
//		}
//
//		return $this->render('assign', ['user' => $user, 'model' => $model, 'rightListBox' => $rightListBox, 'leftListBox' => $leftListBox]);
//	}
}
