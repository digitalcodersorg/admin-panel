<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_address}}".
 *
 * @property string $ID
 * @property string $user_id
 * @property string $address_line1
 * @property string $address_line2
 * @property string $city
 * @property string $land_mark
 * @property string $type
 * @property string $title
 * @property int $country
 * @property int $state
 * @property int $zip
 * @property string $phone_no
 * @property string $email
 */
class UserAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'country', 'state', 'zip'], 'integer'],
            [['address_line1', 'address_line2', 'city', 'land_mark', 'email'], 'string', 'max' => 255],
            [['type', 'phone_no'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'address_line1' => Yii::t('app', 'Address Line1'),
            'address_line2' => Yii::t('app', 'Address Line2'),
            'city' => Yii::t('app', 'City'),
            'land_mark' => Yii::t('app', 'Land Mark'),
            'type' => Yii::t('app', 'Type'),
            'country' => Yii::t('app', 'Country'),
            'state' => Yii::t('app', 'State'),
            'zip' => Yii::t('app', 'Zip'),
            'phone_no' => Yii::t('app', 'Phone No'),
            'email' => Yii::t('app', 'Email'),
            'title' => Yii::t('app', 'Title'),
        ];
    }
    public static function getUserAddress($id = '', $user_id = '', $multiple = false){
        $query = UserAddress::find();
        $query->select([UserAddress::tableName().'.*','c.title as country_name','s.title as state_name']);
        $query->leftJoin(Country::tableName().' as c ', 'c.ID = '.UserAddress::tableName().'.country');
        $query->leftJoin(Country::tableName().' as s ', 's.ID = '.UserAddress::tableName().'.state');
        if(!empty($id)){
            $query->where(['ID'=>$id]);
        }
        if(!empty($user_id)){
            $query->where(['user_id'=>$user_id]);
        }
        $query->orderBy(['ID'=>SORT_DESC]);
        if($multiple){
            return $query->asArray()->all();
        }
        return $query->asArray()->one();
    }
}
