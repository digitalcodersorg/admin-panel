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

    public function search($params = "", $type = 'cms_user', $array = false) {
        $find = User::find();
        $utility = new Utility();
        
        if (!empty($params['username'])) {
        $find->filterWhere(['like', 'username', $utility->validateSearchKeywords($params['username'])])
               ->orFilterWhere(['like', 'email', $utility->validateSearchKeywords($params['username'])]);
        }
        $find->andWhere(['type' => $type]);
        if($array){
            return  $find->orderBy(['updated_at' => SORT_DESC])->asArray()->all();
        }
        return $find->orderBy(['updated_at' => SORT_DESC])->all();
    }

//    public function getUsermeta($user_id = '', $key = '', $single = false) {
//        if (!empty($user_id)) {
//            $db = \Yii::$app->db;
//            $key_sql = !empty($key) ? 'and meta_key = :meta_key' : '';
//            $sql = "select meta_key,meta_value from pnl_user_meta where user_id = :user_id " . $key_sql;
//            $command = $db->createCommand($sql);
//            $command->bindValue(':user_id', $user_id);
//            if (!empty($key)) {
//                $command->bindValue(':meta_key', $key);
//                $result = $command->queryOne();
//                return $result['meta_value'];
//            }else{
//                return $result = $command->queryAll();
//            }
//        } else {
//            return NULL;
//        }
//    }

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
    public function addUserMeta($meta_key, $value, $user_id){
            if(!empty($meta_key) && !empty($user_id)){
            $db = \Yii::$app->db;
            $sql = "insert into pnl_user_meta(user_id,meta_key,meta_value) values(:user_id,:meta_key,:meta_value)";
            $command = $db->createCommand($sql);
            $command->bindValue(':meta_key', $meta_key);
            $command->bindValue(':meta_value', $value);
            $command->bindValue(':user_id', $user_id);
            $result = $command->execute();
            return $result;
            }else{
                return false;
            }
    }
    public function updateUserMeta($meta_key, $value, $user_id){
            if(!empty($meta_key) && !empty($user_id)){
            $db = \Yii::$app->db;
            $sql = "update pnl_user_meta set meta_value = :meta_value where meta_key = :meta_key and user_id = :user_id";
            $command = $db->createCommand($sql);
            $command->bindValue(':meta_key', $meta_key);
            $command->bindValue(':meta_value', $value);
            $command->bindValue(':user_id', $user_id);
            $result = $command->execute();
            return $result;
            }else{
                return false;
            }
    }
    public function getUserMeta($uid = '', $key = ''){
        $db = \Yii::$app->db;
        if(!empty($key) && !empty($uid)){
            $sql = "select * from pnl_user_meta where meta_key = :key and user_id = :uid";
            $command = $db->createCommand($sql);
            $command->bindValue(':key', $key);
            $command->bindValue(':uid', $uid);
            $result = $command->queryOne();
            return $result['meta_value'];
        }else if(!empty($key) && empty($key)){
            $sql = "select * from pnl_user_meta where meta_key = :key";
            $command = $db->createCommand($sql);
            $command->bindValue(':key', $key);
            return $result = $command->queryAll();
        }else if(empty($key) && !empty($key)){
            $sql = "select * from pnl_user_meta where user_id = :uid";
            $command = $db->createCommand($sql);
            $command->bindValue(':uid', $uid);
            return $result = $command->queryAll();
        }
        return NULL;
    }
    public static function getCount($from = '', $type = ''){
        $search = User::find();
        $search->where(['type'=>'frontend_user']);
        if(!empty($from)){
            $andWhere = ['>=', User::tableName() . '.created_at', date_format(date_create($from), "Y-m-d H:i:s")];
            $search = $search->andWhere($andWhere);
        }
        if($type == 'count'){
            return $search->count();
        }
        return $search->asArray()->all();
    }
}
