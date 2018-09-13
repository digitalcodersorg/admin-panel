<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%subscription_item}}".
 *
 * @property string $ID
 * @property string $subcription_id
 * @property string $type
 * @property string $name
 * @property string $serial_no
 * @property int $quantity
 * @property string $mac_lan
 * @property string $mac_wifi
 * @property string $desk
 * @property string $phone
 * @property string $email
 * @property string $created_by
 * @property string $updated_by
 * @property string $created_on
 * @property string $updated_on
 *
 * @property Subscription $subcription
 * @property CmsUser $createdBy
 * @property CmsUser $updatedBy
 */
class SubscriptionItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%subscription_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subcription_id', 'quantity', 'created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['type', 'mac_lan', 'mac_wifi', 'desk', 'phone'], 'string', 'max' => 50],
            [['name', 'serial_no', 'email'], 'string', 'max' => 255],
            [['subcription_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subscription::className(), 'targetAttribute' => ['subcription_id' => 'ID']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => CmsUser::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => CmsUser::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'subcription_id' => Yii::t('app', 'Subcription ID'),
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'serial_no' => Yii::t('app', 'Serial No'),
            'quantity' => Yii::t('app', 'Quantity'),
            'mac_lan' => Yii::t('app', 'Mac Lan'),
            'mac_wifi' => Yii::t('app', 'Mac Wifi'),
            'desk' => Yii::t('app', 'Desk'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcription()
    {
        return $this->hasOne(Subscription::className(), ['ID' => 'subcription_id']);
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
    public static function insertItem($postData = []){
        $subsItem = new SubscriptionItem(); 
        $subsItem->subcription_id = $postData['subcription_id'];
        $subsItem->type = $postData['type'];
        $subsItem->name = $postData['name'];
        $subsItem->serial_no = $postData['serial_no'];
        $subsItem->quantity = $postData['quantity'];
        $subsItem->mac_lan = $postData['mac_lan'];
        $subsItem->mac_wifi = $postData['mac_wifi'];
        $subsItem->desk = $postData['desk'];
        $subsItem->phone = $postData['phone'];
        $subsItem->email = $postData['email'];
        $subsItem->created_by = $postData['user_id'];
        $subsItem->updated_by = $postData['user_id'];
        $subsItem->created_on = date('Y-m-d H:i:s');
        $subsItem->updated_on = date('Y-m-d H:i:s');
        if($subsItem->validate()){
            $subsItem->save();
            return true;
        }
        return false;
    }
    public static function updateItem($postData = []){
        $subsItem = SubscriptionItem::findOne($postData['ID']); 
        $subsItem->type = ($postData['type'] != $subsItem->type) ? $postData['type'] : $subsItem->type;
        $subsItem->name = ($postData['name'] != $subsItem->name) ? $postData['name'] : $subsItem->name;
        $subsItem->serial_no = ($postData['serial_no'] != $subsItem->serial_no) ? $postData['serial_no'] : $subsItem->serial_no;
        $subsItem->quantity = ($postData['quantity'] != $subsItem->quantity) ? $postData['quantity'] : $subsItem->quantity;
        $subsItem->mac_lan = ($postData['mac_lan'] != $subsItem->mac_lan)? $postData['mac_lan'] : $subsItem->mac_lan;
        $subsItem->mac_wifi = ($postData['mac_wifi'] !=  $subsItem->mac_wifi) ? $postData['mac_wifi'] : $subsItem->mac_wifi;
        $subsItem->desk = ($postData['desk'] != $subsItem->desk) ? $postData['desk'] : $subsItem->desk;
        $subsItem->phone = ($postData['phone'] != $subsItem->phone)? $postData['phone']: $subsItem->phone;
        $subsItem->email = ($postData['email'] != $subsItem->email) ? $postData['email']: $subsItem->email;
        $subsItem->updated_by = $postData['user_id'];
        $subsItem->updated_on = date('Y-m-d H:i:s');
        if($subsItem->validate()){
            $subsItem->save();
            return true;
        }
        return false;
    }
}
