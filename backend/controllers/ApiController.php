<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use common\models\Todo;
use common\models\Subscription;
use common\models\SubscriptionItem;
use common\models\Ticket;
use common\models\EmailNotification;
use yii\data\Pagination;
/**
 * Site controller
 */
class ApiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }
    public function actionGetChartData($uid = ''){
        $chartData = [];
        $chartData[] = ['name'=>'All','data'=>Ticket::getChartData(''),"color"=>"#000"];
        $chartData[] = ['name'=>'Open','data'=>Ticket::getChartData('Open'),"color"=>"#cf2929"];
        $chartData[] = ['name'=>'Inprocess','data'=>Ticket::getChartData('Inprocess'),"color"=>"#21a808"];
        $chartData[] = ['name'=>'Closed','data'=>Ticket::getChartData('Closed'),"color"=>"#9E7CD7"];
        $chartData[] = ['name'=>'Resolve','data'=>Ticket::getChartData('Resolve'),"color"=>"#FD6A02"];
        $chartData[] = ['name'=>'Forward','data'=>Ticket::getChartData('Forward'),"color"=>"#5bc0de"];
        return json_encode($chartData);
    }
    public function actionInsertTicket(){
        
    }
    public function actionUpdateTicket(){
        
    }
    public function actionGetTickets(){
        
    }
    public function actionGetSubscription(){
        $subscription = Subscription::getCounts('', '');
        return json_encode($subscription);
    }
    public function actionInsertItem(){
        
    }
    public function actionGetUserData(){
        
    } 
    public function actionUpdateUser(){
        
    }
    public function actionGetSubscriptionItem($sid = ''){
        if(!empty($sid)){
            $subscriptionItem = SubscriptionItem::find()->where(['subcription_id'=>$sid])->asArray()->all();
            return json_encode($subscriptionItem);
        }
        return json_encode(['error'=>'Invalid Request']);
    }
    public function actionAddSubscriptionItem(){
        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();
            if(isset($post['ID'])){
                $response = SubscriptionItem::updateItem(Yii::$app->request->post());
            }else{
                $response = SubscriptionItem::insertItem(Yii::$app->request->post());
            }
            return $response;
        }
        return json_encode(['error'=>'Invalid Request']);
    }
    public function actionDeleteSubscriptionItem(){
        if(Yii::$app->request->post()){
            
        }
        return json_encode(['error'=>'Invalid Request']);
    }
    public function actionGetTodo($uid = '', $page = ''){
        if(!empty($uid)){
            $data = Todo::getTodo($uid, $page);
            return json_encode(['error'=>'','data'=>$data['data'],'total'=>$data['count']]);
        }
        return json_encode(['error'=>'User ID is empty.']);
    }
    public function actionUpdateTodo(){
        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();
            $flag = true;
            if(!empty($post['text'])&& !empty($post['ID'])){
                $flag = Todo::updateTodo($post);
            }else{
                $flag = Todo::insertTodo($post);
            }
            return json_encode(['error'=>($flag ? '0' : 'Invalid Data')]); 
        }
        return json_encode(['error'=>'Invalid Request']);
    }
    
}
