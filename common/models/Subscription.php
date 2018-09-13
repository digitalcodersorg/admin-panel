<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%subscription}}".
 *
 * @property string $ID
 * @property string $subscription_numebr
 * @property string $subscriber_id
 * @property string $status
 * @property int $subscription_period Period in Days
 * @property int $item_quntity
 * @property string $product_detail
 * @property string $address
 * @property string $created_by
 * @property string $updated_by
 * @property string $start_date
 * @property string $end_date
 * @property string $created_on
 * @property string $updated_on
 *
 * @property CmsUser $subscriber
 * @property CmsUser $createdBy
 * @property CmsUser $updatedBy
 * @property UserAddress $address0
 * @property SubscriptionItem[] $subscriptionItems
 */
class Subscription extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%subscription}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subscription_numebr'], 'required'],
            [['subscriber_id', 'subscription_period', 'item_quntity', 'address', 'created_by', 'updated_by'], 'integer'],
            [['status', 'product_detail'], 'string'],
            [['start_date', 'end_date', 'created_on', 'updated_on'], 'safe'],
            [['subscription_numebr'], 'string', 'max' => 50],
            [['subscription_numebr'], 'unique'],
            [['subscriber_id'], 'exist', 'skipOnError' => true, 'targetClass' => CmsUser::className(), 'targetAttribute' => ['subscriber_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => CmsUser::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => CmsUser::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['address'], 'exist', 'skipOnError' => true, 'targetClass' => UserAddress::className(), 'targetAttribute' => ['address' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'subscription_numebr' => Yii::t('app', 'Subscription Numebr'),
            'subscriber_id' => Yii::t('app', 'Subscriber ID'),
            'status' => Yii::t('app', 'Status'),
            'subscription_period' => Yii::t('app', 'Subscription Period'),
            'item_quntity' => Yii::t('app', 'Item Quntity'),
            'product_detail' => Yii::t('app', 'Product Detail'),
            'address' => Yii::t('app', 'Address'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriber()
    {
        return $this->hasOne(CmsUser::className(), ['id' => 'subscriber_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(CmsUser::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(CmsUser::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress0()
    {
        return $this->hasOne(UserAddress::className(), ['ID' => 'address']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptionItems()
    {
        return $this->hasMany(SubscriptionItem::className(), ['subcription_id' => 'ID']);
    }
    public static function getCounts($status = '', $type = ''){
        $search = Subscription::find();
        if(!empty($status)){
            $search->where(['`status`'=>$status]);
        }
        if($type == 'count'){
            return $search->count();
        }
        
        return $search->asArray()->all();
    }
}
