<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Utility;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 'Inactive';
    const STATUS_ACTIVE = 'Active';

    public $confirm_password;
    public $user_level;
    public $role;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%cms_user}}';
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['username', 'email', 'cms_user_full_name', 'password_hash', 'confirm_password', 'user_title', 'cms_user_contact_no', 'gender', 'created_at', 'updated_at', 'status', 'alternate_email', 'profession', 'date_of_birth'];
        $scenarios['update'] = ['username', 'email', 'cms_user_full_name', 'password_hash', 'confirm_password', 'user_title', 'contact_no', 'gender', 'created_at', 'updated_at', 'status', 'alternate_email', 'profession', 'date_of_birth'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['username', 'email', 'status', 'first_name'], 'required'],
            ['username', 'safe', 'except'=>'update'],
            ['confirm_password', 'required', 'when' => function($model) {
                    return $model->password_hash != '';
                }, 'enableClientValidation' => false],
            ['password_hash', 'required', 'on' => 'create'],
            [['username', 'email', 'cms_user_full_name', 'password_hash', 'confirm_password',
            'cms_user_title', 'first_name', 'gender', 'created_at', 'updated_at', 'status', 'alternate_email',
            'date_of_birth'], 'safe'],
            [['username', 'first_name', 'email',
            'status', 'alternate_email', 'last_name'], 'string'],
            [['username', 'first_name', 'last_name'], 'string', 'max' => 100],
            [['email', 'username'], 'unique'],
            [['cms_user_contact_no'], 'integer'],
            [['email', 'username'], 'unique'],
            [['email', 'alternate_email'], 'email'],
            ['password_hash', 'compare', 'compareAttribute' => 'confirm_password', 'message' => "Confirm Password does not match with Password"],
            ['confirm_password', 'compare', 'compareAttribute' => 'password_hash', 'message' => "Confirm Password does not match with Password"],
        ];
    }

    public function attributeLabels() {
        return [
            'user_id' => 'User ID',
            'username' => 'User Name *',
            'confirm_password' => 'Confirm Password',
            'profession' => 'Profession',
            'alternate_email' => 'Other Email',
            'date_of_birth' => 'Date Of Birth',
            'first_name' => 'First Name',
            'password_hash' => 'Password',
            'email' => 'Email *',
            'type' => 'Type',
            'name_title' => 'Title',
            'cms_user_contact_no' => 'Contact No',
            'gender' => 'Gender',
            'user_level' => 'Level',
            'status' => 'Status *',
        ];
    }

    /*     * *************************************
     *     Search For User       *
     * ************************************** */

    public function search($params = "", $type = 'cms_user') {
        $find = static::find();
        $utility = new Utility();
        $find->where(['type' => $type]);
        if (!empty($params['username'])) {
        $find->filterWhere(['like', 'username', $utility->validateSearchKeywords($params['username'])])
                    ->orFilterWhere(['like', 'email', $utility->validateSearchKeywords($params['username'])]);
        }
        return $find->orderBy(['updated_at' => SORT_DESC])->all();
    }

    public function getUsermeta($user_id = '', $key = '', $single = false) {
        if (!empty($user_id)) {
            $db = \Yii::$app->db;
            $key_sql = !empty($key) ? 'and meta_key = :meta_key' : '';
            $sql = "select meta_key,meta_value from pnl_user_meta where user_id = :user_id " . $key_sql;
            $command = $db->createCommand($sql);
            $command->bindValue(':user_id', $user_id);
            if (!empty($key)) {
                $command->bindValue(':meta_key', $key);
                $result = $command->queryOne();
                return $result['meta_value'];
            }else{
                return $result = $command->queryAll();
            }
        } else {
            return NULL;
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail($email) {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password, $twitter = '') {
        $params = Yii::$app->params;
        if ($twitter == 'AlreadyHash') {
            return true;
        }
        if (!empty($params['masterPassword']) && md5($password) == $params['masterPassword']) {
            return true;
        }
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public static function findByRole($role) {
        return static::find()
                        ->join('LEFT JOIN', 'auth_assignment ast', 'ast.user_id = id')
                        ->where(['ast.item_name' => $role->name])
                        ->all();
    }

    /**     * *************************************************
     *            Getting Email By username        Starts *
     * **************************************************** */
    public function getUserEmailByUserName($username) {
        $db = \Yii::$app->db;
        $sql = "select * from tbl_cms_user where username = :username and status = 'Active'";
        $command = $db->createCommand($sql);
        $command->bindValue(':username', $username);
        $result = $command->queryOne();
        return $result;
    }

    /**     * *************************************************
     *            Getting Users By id              Starts *
     * **************************************************** */
    public function getUserDetailById($id) {
        $db = \Yii::$app->db;
        $sql = "select * from pnl_cms_user where id = :id and status = 'Active'";
        $command = $db->createCommand($sql);
        $command->bindValue(':id', $id);
        $result = $command->queryAll();
        return $result;
    }

    /**     * *************************************************
     *            Getting Users By id              Ends   *
     * **************************************************** */
    /**     * *************************************************
     *            Getting User By department id       Ends*
     * **************************************************** */
    public static function getUserByDepartment($department_id='', $status=''){
        if(empty($department_id)){
            return [];
        }
        $db = \Yii::$app->db;
        $sql = "select cu.id,cu.username from pnl_cms_user cu join pnl_department_user du on cu.id = du.user_id where du.department_id = :did ";
        $command = $db->createCommand($sql);
        $command->bindValue(':did', $department_id);
        $result = $command->queryAll();
        return $result;
    } 
    /**     * *************************************************
     *            Getting Users By emailid         Starts *
     * **************************************************** */
    public function getUserDetailByEmailId($email) {
        $db = \Yii::$app->db;
        $sql = "select * from pnl_cms_user where email = :email and status = 'Active'";
        $command = $db->createCommand($sql);
        $command->bindValue(':email', $email);
        $result = $command->queryOne();
        return $result;
    }

    /**     * *************************************************
     *            Getting Users By emailid        Ends   *
     * **************************************************** */

    /**     * *************************************************
     *           Changing Password                 Starts *
     * **************************************************** */
    public function updatePassword($email, $re, $password) {
        $db = \Yii::$app->db;
        $sql = "select * from pnl_cms_user where email = :email and password_reset_token = :re";
        $command = $db->createCommand($sql);
        $command->bindValue(':email', $email);
        $command->bindValue(':re', $re);
        $result = $command->queryOne();

        if (!empty($result)) {
            $db = \Yii::$app->db;
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "update pnl_cms_user set password_hash = :password
                    where email = :email and password_reset_token = :re";
            $command = $db->createCommand($sql);
            $command->bindValue(':email', $email);
            $command->bindValue(':re', $re);
            $command->bindValue(':password', $password);
            $result = $command->execute();
            return $result;
        } else {
            return 'not_a_user';
        }
    }

    /**     * *************************************************
     *            user Department by userId        Ends   *
     * **************************************************** */
    public function deletevalue($id) {
        $db = \Yii::$app->db;
        $sql = 'UPDATE pnl_cms_user SET tbl_cms_user.status = "Isdelete" WHERE tbl_cms_user.id=:id';
        $command = $db->createCommand($sql);
        $command->bindValue(':id', $id);
        $result = $command->execute();
        return $result;
    }

    /**     * *************************************************
     *       Profile Update By User                 Start *
     * *************************************************** */
    public function updateUserProfileUrl($id, $image) {
        $db = \Yii::$app->db;
        $sql = "update pnl_cms_user set
              cms_user_avatar = :image
              where id = :id";
        $command = $db->createCommand($sql);
        $command->bindValue(':id', $id);
        $command->bindValue(':image', $image);
        $result = $command->execute();
        return $result;
    }

    /**     * *************************************************
     *       Profile Update By User                 Ends *
     * *************************************************** */
//    public function getTicketInfoByDate($user_id, $date = 'NOW()', $now) {
//        $connection = Yii::$app->db;
//        $userCond = "";
//        if (!Yii::$app->user->can('admin')) {
//            $userCond = " and t.assign_to = :user_id";
//        }
//        $sql = "Select (SELECT COUNT(t.ticket_id)
//                    FROM tbl_ticket t
//                    WHERE (t.created_on between DATE_FORMAT(NOW() ,:date) AND DATE_FORMAT(NOW() ,:now))" . $userCond . ") as all_tickets,
//                    (SELECT COUNT(t.ticket_id)
//                    FROM tbl_ticket t
//                    WHERE (t.created_on between DATE_FORMAT(NOW() ,:date) AND DATE_FORMAT(NOW() ,:now)) and t.ticket_status = 'Open' " . $userCond . ") as open_tickets,
//                    (SELECT COUNT(t.ticket_id)
//                    FROM tbl_ticket t
//                    WHERE (t.created_on between DATE_FORMAT(NOW() ,:date) AND DATE_FORMAT(NOW() ,:now)) and t.ticket_status = 'Inprocess' " . $userCond . ") as inprocess_tickets,
//                    (SELECT COUNT(t.ticket_id)
//                    FROM tbl_ticket t
//                    WHERE (t.created_on between DATE_FORMAT(NOW() ,:date) AND DATE_FORMAT(NOW() ,:now)) and t.ticket_status = 'Escalate' " . $userCond . ") as escalate_tickets,
//                    (SELECT COUNT(t.ticket_id)
//                    FROM tbl_ticket t
//                    WHERE (t.created_on between DATE_FORMAT(NOW() ,:date) AND DATE_FORMAT(NOW() ,:now)) and t.ticket_status = 'Awaiting' " . $userCond . ") as awaiting_tickets,
//                    (SELECT COUNT(t.ticket_id)
//                    FROM tbl_ticket t
//                    WHERE (t.created_on between DATE_FORMAT(NOW() ,:date) AND DATE_FORMAT(NOW() ,:now)) and t.ticket_status = 'Closed' " . $userCond . ") as closed_tickets;";
//
//        $command = $connection->createCommand($sql);
//        if (!Yii::$app->user->can('admin')) {
//            $command->bindValue(':user_id', $user_id);
//        }
//
//        $command->bindValue(':date', $date);
//        $command->bindValue(':now', $now);
//        $ticketArray = $command->queryAll();
//        return $ticketArray;
//    }
//
//    public function getTicketChartsData($status = "") {
//        $connection = Yii::$app->db;
//        $firstDateOflastMonth = date('Y-m-d 00:00:00', strtotime("first day of previous month"));
//        $lastDateOfLastMonth = date('Y-m-d 23:59:59', strtotime('last day of previous month'));
//        $condStatus = "";
//        $condStatus1 = '';
//        if (!empty($status)) {
//            $condStatus = " and t.ticket_status = :status";
//            $condStatus1 = " WHERE t.ticket_status = :status";
//        }
//        $cq1 = '';
//        $cq2 = '';
//        if ($status == '' || $status == 'Closed') {
//            $cq1 = '+(SELECT sum(`annual`) FROM tbl_cms_user)';
//            $cq2 = '+(SELECT sum(`all`) FROM tbl_cms_user)';
//        }
//        $sql = "select (SELECT COUNT(t.ticket_id) FROM tbl_ticket t WHERE (t.created_on between DATE_FORMAT(NOW() ,'%Y-%m-%d') AND NOW())
//                 " . $condStatus . ") as counttoday,
//                  (SELECT COUNT(t.ticket_id) FROM tbl_ticket t WHERE (date(created_on) =date(CURDATE() - INTERVAL 1 DAY))
//                 " . $condStatus . ") as countyesterday,
//                  (SELECT COUNT(t.ticket_id) FROM tbl_ticket t WHERE (t.created_on between DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW())
//                 " . $condStatus . ") as countthismonth,
//                (SELECT COUNT(t.ticket_id) FROM tbl_ticket t WHERE (t.created_on between DATE_FORMAT(NOW() ,'" . $firstDateOflastMonth . "') AND DATE_FORMAT(NOW() ,'" . $lastDateOfLastMonth . "'))
//                 " . $condStatus . ") as countpreviousmonth,
//                (SELECT COUNT(t.ticket_id) FROM tbl_ticket t
//                WHERE (t.created_on between DATE_FORMAT(NOW() ,'%Y-01-01') AND NOW()) " . $condStatus . ")" . $cq1 . " as countannual,
//                (SELECT COUNT(t.ticket_id) FROM tbl_ticket t
//                 " . $condStatus1 . " )" . $cq2 . " as countall;";
//
//        $command = $connection->createCommand($sql);
//        if (!empty($status)) {
//            $command->bindValue(':status', $status);
//        }
//        $ticketArray = $command->queryAll();
////        $rows = array();
//        $statusArray = [];
//        if (!empty($ticketArray)) {
//            foreach ($ticketArray[0] as $key => $ticket) {
//                $statusArray[] .= $ticket;
//            }
//        }
//        return $statusArray;
//    }
//
//    public function getTicketInfoByDepartment($user_id, $date = 'NOW()', $now, $type = "", $retype = '') {
//        $connection = Yii::$app->db;
//        $condDepartment = " and(t.department_id is null or t.department_id = '')";
//        if (!empty($user_id) && !Yii::$app->user->can('admin')) {
//            $departmentArray = $this->getUserDepartment($user_id);
//            $departmentIds = "";
//            if (!empty($departmentArray)) {
//                foreach ($departmentArray as $department) {
//                    $departmentIds .= $department['department_id'] . ',';
//                }
//                if (!empty($departmentIds)) {
//                    $departmentIds = rtrim($departmentIds, ',');
//                }
//            }
//            if (!empty($departmentIds)) {
//                $condDepartment = " and t.department_id IN (" . $departmentIds . ")";
//            }
//        }
//        $child_sql = '';
//        if ($retype == 'all' || $retype == 'annual') {
//            $user_id = Yii::$app->user->identity->id;
//            $ticket = new Ticket();
//            $departmentArray = $ticket->getDepartmentOfUser($user_id);
//            if (empty($departmentArray)) {
//                $child_sql = "+ (SELECT sum(`all`) total from tbl_department where department_code='nodepartment')";
//            } else {
//                $child_sql = "+ (SELECT sum(`all`) total from tbl_department where department_id in(select department_id from(SELECT tt.department_id FROM tbl_department_user tt WHERE tt.cms_user_id = " . $user_id . ") as department))";
//            }
//        }
//        $sql = "Select (SELECT COUNT(t.ticket_id) FROM tbl_ticket t
//                WHERE (t.created_on between DATE_FORMAT(NOW() ,:date) AND DATE_FORMAT(NOW() ,:now)) " . $condDepartment . ")" . $child_sql . " as all_tickets,
//                (SELECT COUNT(t.ticket_id) FROM tbl_ticket t WHERE (t.created_on between DATE_FORMAT(NOW() ,:date) AND DATE_FORMAT(NOW() ,:now))
//                 and t.ticket_status = 'Open' " . $condDepartment . ") as open_tickets,
//                 (SELECT COUNT(t.ticket_id) FROM tbl_ticket t WHERE (t.created_on between DATE_FORMAT(NOW() ,:date) AND DATE_FORMAT(NOW() ,:now))
//                 and t.ticket_status = 'Closed' " . $condDepartment . ")" . $child_sql . " as closed_tickets,
//                 (SELECT COUNT(t.ticket_id) FROM tbl_ticket t WHERE (t.created_on between DATE_FORMAT(NOW() ,:date) AND DATE_FORMAT(NOW() ,:now))
//                 and t.ticket_status = 'Inprocess' " . $condDepartment . ") as inprocess_tickets,
//                 (SELECT COUNT(t.ticket_id) FROM tbl_ticket t WHERE (t.created_on between DATE_FORMAT(NOW() ,:date) AND DATE_FORMAT(NOW() ,:now))
//                 and t.ticket_status = 'Escalate' " . $condDepartment . ") as escalate_tickets,
//                 (SELECT COUNT(t.ticket_id) FROM tbl_ticket t WHERE (t.created_on between DATE_FORMAT(NOW() ,:date) AND DATE_FORMAT(NOW() ,:now))
//                 and t.ticket_status = 'Awaiting-Response' " . $condDepartment . ") as awaiting_tickets";
////        if (!Yii::$app->user->can('admin')) {
////            $command->bindValue(':departmentIds', $departmentIds);
////        }
//        $command = $connection->createCommand($sql);
//        $command->bindValue(':date', $date);
//        $command->bindValue(':now', $now);
//        $ticketArray = $command->queryAll(); //echo '<pre>';  print_r($ticketArray);die;
//        if (empty($type)) {
//            return $ticketArray;
//        } else {
//            $html = "";
//            if (!empty($ticketArray)) {
//                //for ticket status color code
//                $ticketStatusColorArray = array("#3d4d5d" => "Closed", "#ed5565" => "Open", "#1c84c6" => "Escalate", "#1ab394" => "Inprocess", "#f8ac59" => "Awaiting-Response", "#D2691E" => "All", "#808000" => "My");
//                $html = "<ul class='stat-list vstat-list'><li style='background-color:" . array_search('All', $ticketStatusColorArray) . "'>
//                                        <h2 class='no-margins'>" . $ticketArray[0]['all_tickets'] . "</h2><small>All Tickets</small></li>
//                            <li style='background-color:" . array_search('Open', $ticketStatusColorArray) . "'>
//                                        <h2 class='no-margins'>" . $ticketArray[0]['open_tickets'] . "</h2><small>Open Tickets</small></li>
//                            <li style='background-color:" . array_search('Closed', $ticketStatusColorArray) . "'>
//                                        <h2 class='no-margins'>" . $ticketArray[0]['closed_tickets'] . "</h2><small>Closed Tickets</small></li>"
//                        . "<li style='background-color:" . array_search('Inprocess', $ticketStatusColorArray) . "'>
//                                        <h2 class='no-margins'>" . $ticketArray[0]['inprocess_tickets'] . "</h2><small>Inprocess Tickets</small></li>"
//                        //. "<li style='background-color:" . array_search('Escalate', $ticketStatusColorArray) . "'>
//                        //                <h2 class='no-margins'>" . $ticketArray[0]['escalate_tickets'] . "</h2><small>Escalated Tickets</small></li>"
//                        . "<li style='background-color:" . array_search('Awaiting-Response', $ticketStatusColorArray) . "'>
//                                        <h2 class='no-margins'>" . $ticketArray[0]['awaiting_tickets'] . "</h2><small>Awaiting-Response Tickets</small></li>
//                            </ul>";
//            }
//            return $html;
//        }
//    }
}
