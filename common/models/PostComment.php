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
 */
class PostComment extends \yii\db\ActiveRecord
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
}
