<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%notification}}".
 *
 * @property string $ID
 * @property string $created_by
 * @property string $notification_for
 * @property string $text
 * @property string $url
 * @property string $noti_status
 * @property string $created_on
 *
 * @property CmsUser $createdBy
 * @property CmsUser $notificationFor
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%notification}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by', 'notification_for'], 'integer'],
            [['text', 'url', 'noti_status'], 'string'],
            [['created_on'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['notification_for'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['notification_for' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'created_by' => Yii::t('app', 'Created By'),
            'notification_for' => Yii::t('app', 'Notification For'),
            'text' => Yii::t('app', 'Text'),
            'url' => Yii::t('app', 'Url'),
            'noti_status' => Yii::t('app', 'Noti Status'),
            'created_on' => Yii::t('app', 'Created On'),
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
    public function getNotificationFor()
    {
        return $this->hasOne(User::className(), ['id' => 'notification_for']);
    }
}
