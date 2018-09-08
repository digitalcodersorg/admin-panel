<?php

namespace backend\controllers;
use yii\web\Controller;
use common\models\Subscription;
use common\models\SubscriptionItem;
use common\models\UserAddress;
class SubscriptionController extends Controller
{
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
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionGetSubscription($sid = ''){
            $subscription = Subscription::find()->where(['ID'=>$sid])->asArray()->one();
            $address = [];
            if(!empty($subscription)){
                $address = UserAddress::find()->where(['ID'=>$subscription['address']])->asArray()->one();
            }
        return json_encode(['subcription' => $subscription,'address'=>$address]);
        
    }
    public function actionUpdateSubscription(){
        
    }
}
