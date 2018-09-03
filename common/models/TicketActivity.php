<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%ticket_activity}}".
 *
 * @property string $ID
 * @property string $text
 * @property string $subject
 * @property string $status
 * @property string $priority
 * @property string $type
 * @property string $ticket_id
 * @property string $created_by
 * @property string $updated_by
 * @property string $created_on
 * @property string $updated_on
 *
 * @property CmsUser $createdBy
 * @property CmsUser $updatedBy
 * @property Tickets $ticket
 */
class TicketActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ticket_activity}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'status', 'priority'], 'string'],
            [['ticket_id', 'created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['subject'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 50],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket_id' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Text'),
            'subject' => Yii::t('app', 'Subject'),
            'status' => Yii::t('app', 'Status'),
            'priority' => Yii::t('app', 'Priority'),
            'type' => Yii::t('app', 'Type'),
            'ticket_id' => Yii::t('app', 'Ticket ID'),
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
    public function getTicket()
    {
        return $this->hasOne(Tickets::className(), ['ID' => 'ticket_id']);
    }
    public function getActivities($ticket_id){
        if(!empty($ticket_id)){
            
        }
        return NULL;
    }
    public function insertActivity($user_id, $ticket_id, $text,$subject, $status, $priority, $type = "note"){
        if(!empty($ticket_id) && !empty($text) && !empty($subject) && !empty($user_id)){
            $activity = new TicketActivity();
            $activity->text = $text;
            $activity->subject = $subject;
            $activity->status = $status;
            $activity->priority = $priority;
            $activity->type = $type;
            $activity->ticket_id = $ticket_id;
            $activity->created_by = $user_id;
            $activity->updated_by = $user_id;
            $activity->created_on = date('Y-m-d H:i:s');
            $activity->updated_on = date('Y-m-d H:i:s');
            if($activity->validate()){
                $activity->save();
                return $activity;
            }            
        }
        return false;
    }
}
