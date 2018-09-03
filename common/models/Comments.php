<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post_comments}}".
 *
 * @property string $ID
 * @property string $comment_text
 * @property string $comment_status
 * @property string $created_by
 * @property string $updated_by
 * @property string $approved_by
 * @property string $created_on
 * @property string $updated_on
 *
 * @property CmsUser $createdBy
 * @property CmsUser $updatedBy
 * @property CmsUser $approvedBy
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%post_comments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_text', 'comment_status'], 'string'],
            [['created_by', 'updated_by', 'approved_by'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['approved_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['approved_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'comment_text' => Yii::t('app', 'Comment Text'),
            'comment_status' => Yii::t('app', 'Comment Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'approved_by' => Yii::t('app', 'Approved By'),
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
    public function getApprovedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'approved_by']);
    }
}
