<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%country}}".
 *
 * @property int $ID
 * @property int $parent
 * @property string $title
 * @property string $std
 * @property string $code
 * @property string $phone_code
 * @property string $created_by
 * @property string $updated_by
 * @property string $created_on
 * @property string $updated_on
 *
 * @property CmsUser $createdBy
 * @property CmsUser $updatedBy
 * @property Country $parent0
 * @property Country[] $countries
 * @property UserAddress[] $userAddresses
 * @property UserAddress[] $userAddresses0
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%country}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent', 'created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['title', 'std', 'code'], 'string', 'max' => 50],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['parent' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'parent' => Yii::t('app', 'Parent'),
            'title' => Yii::t('app', 'Title'),
            'std' => Yii::t('app', 'Std'),
            'code' => Yii::t('app', 'Code'),
            'phone_code' => Yii::t('app', 'Phone Code'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Country::className(), ['ID' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountries()
    {
        return $this->hasMany(Country::className(), ['parent' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddresses()
    {
        return $this->hasMany(UserAddress::className(), ['country' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAddressesByState()
    {
        return $this->hasMany(UserAddress::className(), ['state' => 'ID']);
    }
    public static function getCountryList(){
        $countries =  Country::find()->select('ID,title')->where(['parent'=>NULL])->all();
        $countryList = [];
        foreach ($countries as $country){
            $countryList[$country->ID] = $country->title;
        }
        return $countryList;
    }
    public static function getStateList($country){
        if(empty($country)){
            return [];
        }
        $states =  Country::find()->select('ID,title')->where(['parent'=>$country])->all();
        $stateList = [];
        foreach ($states as $state){
            $stateList[$state->ID] = $state->title;
        }
        return $stateList;
    }
}
