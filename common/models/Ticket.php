<?php

namespace common\models;

use Yii;
use common\models\User;
use common\models\Department;
use common\models\Utility;
use yii\data\Pagination;
use yii\helpers\Url;
/**
 * This is the model class for table "{{%tickets}}".
 *
 * @property string $ID
 * @property string $ticket_text
 * @property string $ticket_code
 * @property int $ticket_subject
 * @property string $ticket_status
 * @property string $ticket_priority
 * @property string $assigned_to
 * @property string $department_id
 * @property string $assigned_by
 * @property string $notify
 * @property string $category
 * @property string $created_by
 * @property string $updated_by
 * @property string $ticket_owener
 * @property string $ticket_contacts
 * @property string $created_on
 * @property string $updated_on
 * @property string $status_updated_on
 *
 * @property TicketActivity[] $ticketActivities
 * @property CmsUser $assignedTo
 * @property CmsUser $assignedBy
 * @property CmsUser $createdBy
 * @property CmsUser $updatedBy
 * @property CmsUser $ticketOwener
 * @property Department $department
 */
class Ticket extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%tickets}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ticket_text', 'ticket_status', 'ticket_code', 'ticket_priority', 'ticket_contacts'], 'string'],
            [['ticket_subject', 'assigned_to', 'department_id', 'assigned_by', 'created_by', 'updated_by', 'ticket_owener'], 'integer'],
            [['created_on', 'updated_on', 'status_updated_on'], 'safe'],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['assigned_to' => 'id']],
            [['assigned_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['assigned_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['ticket_owener'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['ticket_owener' => 'id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'ID' => Yii::t('app', 'ID'),
            'ticket_code' => Yii::t('app', 'Ticket Code'),
            'category' => Yii::t('app', 'Category'),
            'ticket_text' => Yii::t('app', 'Ticket Text'),
            'ticket_subject' => Yii::t('app', 'Ticket Subject'),
            'ticket_status' => Yii::t('app', 'Ticket Status'),
            'notify' => Yii::t('app', 'Notification'),
            'ticket_priority' => Yii::t('app', 'Ticket Priority'),
            'assigned_to' => Yii::t('app', 'Assigned To'),
            'department_id' => Yii::t('app', 'Department ID'),
            'assigned_by' => Yii::t('app', 'Assigned By'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'ticket_owener' => Yii::t('app', 'Ticket Owener'),
            'ticket_contacts' => Yii::t('app', 'Ticket Contacts'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'status_updated_on' => Yii::t('app', 'Status Updated On'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketActivities() {
        return $this->hasMany(TicketActivity::className(), ['ticket_id' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTo() {
        return $this->hasOne(User::className(), ['id' => 'assigned_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedBy() {
        return $this->hasOne(User::className(), ['id' => 'assigned_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicketOwener() {
        return $this->hasOne(User::className(), ['id' => 'ticket_owener']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment() {
        return $this->hasOne(Department::className(), ['ID' => 'department_id']);
    }

    public static function search($params, $action = '', $role = '', $user_id = '') {
        $utility = new Utility();
        $select = [Ticket::tableName() . '.*',
            'u1.username as created_by_name',
            'u2.username as updated_by_name',
            'u3.username as ticket_owener_name',
            'u4.username as assigned_to_name',
            'd.name as department_name',
        ];
        $search = Ticket::find();
        $search->select($select);

        $search->leftJoin(User::tableName() . ' as u1 ', 'u1.id = ' . Ticket::tableName() . '.created_by');
        $search->leftJoin(User::tableName() . ' as u2 ', 'u2.id = ' . Ticket::tableName() . '.updated_by');
        $search->leftJoin(User::tableName() . ' as u3 ', 'u3.id = ' . Ticket::tableName() . '.ticket_owener');
        $search->leftJoin(User::tableName() . ' as u4 ', 'u4.id = ' . Ticket::tableName() . '.assigned_to');
        $search->leftJoin(Department::tableName() . ' as d ', 'd.id = ' . Ticket::tableName() . '.department_id');
        if (!empty($params['id'])) {
            $search = $search->andWhere([Ticket::tableName() . '.ID' => $params['id']]);
        }
        if (!empty($params['tickets_filter'])) {
            if ($params['tickets_filter'] == 'my') {
                $search = $search->andWhere([Ticket::tableName() . '.assigned_to' => $user_id]);
            } else if ($params['tickets_filter'] == 'all' && $role == 'assigner') {
                $search = $search->andWhere([Ticket::tableName() . '.assigned_to' => null]);
            }
        } else if (($role == 'assigner')) {
            $search = $search->andWhere([Ticket::tableName() . '.assigned_to' => null]);
        }
        if (!empty($params['category'])) {
            $search = $search->andWhere([Ticket::tableName() . '.category' => $params['category']]);
        }
        if (!empty($params['priority'])) {
            $search = $search->andWhere([Ticket::tableName() . '.ticket_priority' => $params['priority']]);
        }
        if (!empty($params['status'])) {
            $search = $search->andWhere([Ticket::tableName() . '.ticket_status' => $params['status']]);
        }
        if (!empty($params['reponse'])) {
            $search = $search->andWhere([Ticket::tableName() . '.notify' => 'unseen']);
        }
        if (!empty($params['subject'])) {
            $search = $search->andWhere([Ticket::tableName() . '.ticket_subject' => $params['subject']]);
        }
        if (!empty($params['user'])) {
            $search = $search->andWhere([Ticket::tableName() . '.assigned_to' => $params['user']]);
        }
        if (!empty($params['category'])) {
            $search = $search->andWhere([Ticket::tableName() . '.category' => $params['category']]);
        }
        if (!empty($params['ticket_from']) && !empty($params['ticket_to'])) {

            $andWhere = ['between', Ticket::tableName() . '.created_on',
                date_format(date_create($params['ticket_from']), "Y-m-d H:i:s"),
                date_format(date_create($params['ticket_to']), "Y-m-d H:i:s")];

            $search = $search->andWhere($andWhere);
        } else if (!empty($params['ticket_from']) && empty($params['ticket_to'])) {
            $andWhere = ['>=', Ticket::tableName() . '.created_on', date_format(date_create($params['ticket_from']), "Y-m-d H:i:s")];
            $search = $search->andWhere($andWhere);
        } else if (empty($params['ticket_from']) && !empty($params['ticket_to'])) {
            $andWhere = ['<=', Ticket::tableName() . '.created_on', date_format(date_create($params['ticket_to']), "Y-m-d H:i:s")];
            $search = $search->andWhere($andWhere);
        }
        if (!empty($params['department'])) {
            $search = $search->andWhere([Ticket::tableName() . '.department_id' => $params['department']]);
        }


        if (!empty($params['search_text'])) {
            $keywoed = $utility->validateSearchKeywords($params['search_text']);
            $search->andFilterWhere([
                'or',
                ['like', 'u1.username', $keywoed],
                ['like', 'u3.username', $keywoed],
                ['like', 'u4.username', $keywoed],
                ['like', Ticket::tableName() . '.ticket_text', $keywoed],
                ['like', Ticket::tableName() . '.ticket_code', $keywoed],
            ]);
        }
        $page = isset($params['page']) ? (int) $params['page'] : 1;
        //$limit = Yii::$app->params['ticket_count'];
        $limit = 20;
        $offset = ($page - 1) * $limit;
//return total tweet count if action is count
        if (!empty($action) && $action === 'count') {
            return $search->count();
        }

        $pagination = new Pagination(['totalCount' => $search->count(), 'defaultPageSize' => $limit]);
        $data = $search->limit($limit)
                ->offset($offset)
                ->orderBy(['created_on' => SORT_DESC])
                ->asArray()
                ->all();
        return [
            'data' => $data,
            'pagination' => $pagination
        ];
    }

    public static function assignTicket($post = []) {
        $ticket = Ticket::find()->where(['ticket_code' => $post['ticket_code']])->one();
        if (!empty($ticket)) {
            $ticket->assigned_to = $post['user'];
            $ticket->assigned_by = $post['assigned_by'];
            $ticket->department_id = $post['department'];
            $ticket->updated_on = date('Y-m-d H:i:s');
            $ticket->updated_by = $post['assigned_by'];
            if ($ticket->save()) {
                $userDetail = User::find()->where(['id' => $ticket->assigned_to])->asArray()->one();
                $assigniDetail = User::find()->where(['id' => $ticket->assigned_by])->asArray()->one();
                if (!empty($post['reply-text'])) {
                    $activity = new TicketActivity();
                    $type = ($post['reply-to-user'] == "yes") ? "response" : "note";
                    $activity->insertActivity($post['assigned_by'], $ticket->ID, $post['reply-text'], "Ticket assigned to " . $userDetail['username'], $ticket->ticket_status, $ticket->ticket_priority, 'note');
                }
                EmailNotification::addEmailToSend([
                    'to_emails' => array($userDetail['email'] => $userDetail['username']),
                    'to_name' => $userDetail['username'],
                    'subject' => 'A Ticket Assigned To You',
                    'email_body' => json_encode([
                        'assigned_to_name' => $userDetail['username'],
                        'assigned_by_name' => $assigniDetail['username'],
                        'ticket_url' => Url::base(true).'ticket/view?id=' . $ticket->ID,
                    ]),
                    'template_name' => 'assign_ticket',
                    'created_by' => $assigniDetail['id'],
                ]);
                return true;
            }
        }
        return false;
    }

    public static function updateTicket($postValues = [], $user_id = '', $username = '') {
        $activity = new TicketActivity();
        if (!empty($postValues['ticket_id'] && !empty($postValues['reply-text']))) {
            $ticket = Ticket::findOne($postValues['ticket_id']);
            if (empty($ticket)) {
                return json_encode(['error'=>'Ticket Not Found With Given ID']);
            }
            $ticket->ticket_priority = $postValues['ticket_priority'];
            $type = '';
            if ($postValues['ticket_status'] == "Forward") {
                $ticket->ticket_status = "Forward";
                $ticket->department_id = $postValues['depart'];
                $ticket->forwarded_to = $postValues['user'];
                $ticket->status_updated_on = date('Y-m-d H:i:s');
                $userb = User::find()->select(['id', 'username', 'email'])->where(['id' => $postValues['user']])->one();
                $activityMessage = ($postValues['reply-to-user'] == 'yes') ? $username . " forwarded this ticket to " . $userb->username . " with reply to user." : $username . " forwarded this ticket to " . $userb->username . " with note.";
                $type = ($postValues['reply-to-user'] == 'yes') ? "response" : "forward";
                EmailNotification::addEmailToSend([
                    'to_emails' => array($userb->email => $userb->username),
                    'to_name' => $userb->username,
                    'subject' => 'A Ticket Forwarded To You',
                    'email_body' => json_encode([
                        'forwarded_to_name' => $userb->username,
                        'forwarded_by_name' => $username,
                        'ticket_url' => Url::base(true).'ticket/view?id=' . $ticket->ID,
                    ]),
                    'template_name' => 'forward_ticket',
                    'created_by' => $user_id,
                ]);
            } else {
                $ticket->ticket_status = $postValues['ticket_status'];
                $activityMessage = ($postValues['reply-to-user'] == 'yes') ? $username . " replied to customer." : $username . " posted a note.";
                $type = ($postValues['reply-to-user'] == 'yes') ? "response" : "note";
            }
            $ticket->updated_on = date('Y-m-d H:i:s');
            $ticket->updated_by = $user_id;
            if ($ticket->validate()) {
                $ticket->save();
                $activity = $activity->insertActivity($user_id, $ticket->ID, $postValues['reply-text'], $activityMessage, $ticket->ticket_status, $ticket->ticket_priority, $type);
                $activity->toArray();
                return json_encode(['subject' => $activity->subject, 'text' => $activity->text, 'status' => $activity->status, 'priority' => $activity->priority, 'type' => $activity->type, 'created_by' => $username, 'created_on' => $activity->created_on]);
            } else {
                return json_encode(['error'=>'Error in Ticket Validate']);
            }
        }
        return json_encode(['error'=>'Reply Cannot Be Blank']);
    }

}
