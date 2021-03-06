<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%email_notification}}".
 *
 * @property int $id
 * @property string $template_name
 * @property string $to_email_id
 * @property string $to_name
 * @property string $reply_to_email_id
 * @property string $cc
 * @property string $bcc
 * @property string $from_email_id
 * @property string $from_name
 * @property string $subject
 * @property string $email_body
 * @property string $created_on
 * @property string $created_by
 *
 * @property CmsUser $createdBy
 */
class EmailNotification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%email_notification}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['template_name', 'to_email_id','to_name','subject','email_body'], 'required'],
            [['to_email_id', 'email_body'], 'string'],
            [['created_on'], 'safe'],
            [['created_by'], 'integer'],
            [['template_name'], 'string', 'max' => 50],
            [['to_name', 'reply_to_email_id', 'cc', 'bcc', 'from_name'], 'string', 'max' => 100],
            [['from_email_id'], 'string', 'max' => 500],
            [['subject'], 'string', 'max' => 250],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'template_name' => Yii::t('app', 'Template Name'),
            'to_email_id' => Yii::t('app', 'To Email ID'),
            'to_name' => Yii::t('app', 'To Name'),
            'reply_to_email_id' => Yii::t('app', 'Reply To Email ID'),
            'cc' => Yii::t('app', 'Cc'),
            'bcc' => Yii::t('app', 'Bcc'),
            'from_email_id' => Yii::t('app', 'From Email ID'),
            'from_name' => Yii::t('app', 'From Name'),
            'subject' => Yii::t('app', 'Subject'),
            'email_body' => Yii::t('app', 'Email Body'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by' => Yii::t('app', 'Created By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
    
    
    public static function addEmailToSend($options = []) {
        $email = new EmailNotification();
        $email->from_email_id = empty($options['from_email']) ? \Yii::$app->params['supportEmail'] : $options['from_email'];
        $email->from_name = empty($options['from_name']) ? \Yii::$app->params['supportName'] : $options['from_name'];
        $email->to_name = $options['to_name'];
        $email->to_email_id = json_encode($options['to_emails']);
        $email->template_name = $options['template_name'];
        $email->subject = $options['subject'];
        $email->email_body = $options['email_body'];
        $email->created_by = $options['created_by'];
        $email->cc = empty($options['cc']) ? NULL : $options['cc'];
        $email->bcc = empty($options['bcc']) ? NULL : $options['bcc'];
        if($email->validate()){
            $email->save();
            return true;
        }else{
            return false;
        }
      
    }
}
