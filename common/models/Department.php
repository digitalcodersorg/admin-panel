<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%department}}".
 *
 * @property string $ID
 * @property string $name
 * @property string $description
 * @property string $type
 * @property string $address
 * @property integer $parent
 * @property string $status
 * @property integer $department_head
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_on
 * @property string $updated_on
 *
 * @property User $departmentHead
 * @property User $createdBy
 * @property User $updatedBy
 * @property Department $parent0
 * @property Department[] $departments
 * @property UserAddress $address0
 * @property Tickets[] $tickets
 */
class Department extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 'Inactive';
    const STATUS_ACTIVE = 'Active';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%department}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['name', 'created_by', 'updated_by','type','status'], 'required'],
            [['description'], 'string'],
            [['address', 'parent', 'department_head', 'created_by', 'updated_by'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 50],
            [['department_head'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['department_head' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['parent' => 'ID']],
            [['address'], 'exist', 'skipOnError' => true, 'targetClass' => UserAddress::className(), 'targetAttribute' => ['address' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'type' => Yii::t('app', 'Type'),
            'address' => Yii::t('app', 'Address'),
            'parent' => Yii::t('app', 'Parent'),
            'status' => Yii::t('app', 'Status'),
            'department_head' => Yii::t('app', 'Department Head'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartmentHead()
    {
        return $this->hasOne(User::className(), ['id' => 'department_head']);
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
        return $this->hasOne(Department::className(), ['ID' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Department::className(), ['parent' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(UserAddress::className(), ['ID' => 'address']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['department_id' => 'ID']);
    }
    /** **************************************************
    *            ListBox For Department Form   Starts   *
    *****************************************************/

    public function getUserLeftListBoxData(){
        $db = \Yii::$app->db;
        $sql = "select id,username as name from pnl_cms_user where status = 'Active' and id != 1 and type='cms_user'";
        $command = $db->createCommand($sql);
        $result = $command->queryAll();
        return $result;
        }

     public function getUserRightListBoxData($department_id){
        $db = \Yii::$app->db;
        $sql = "select cu.id,cu.username as name from pnl_department_user du
                join pnl_cms_user cu on cu.id = du.user_id
                where cu.status = 'Active' and du.department_id = :department_id";
        $command = $db->createCommand($sql);
        $command->bindValue(':department_id',$department_id);
        $result = $command->queryAll();
        return $result;
        }

      public function deletePreviousList($department_id){
        $db = \Yii::$app->db;
        $sql = "delete from pnl_department_user where department_id = :department_id";
        $command = $db->createCommand($sql);
        $command->bindValue(':department_id',$department_id);
        $result = $command->execute();
        return $result;
    }

     public function insertListBoxValues($department_id,$user_id){
        $db = \Yii::$app->db;
        $sql = "insert into pnl_department_user (department_id,user_id)
                values (:department_id,:user_id)";
        $command = $db->createCommand($sql);
        $command->bindValue(':department_id',$department_id);
        $command->bindValue(':user_id',$user_id);
        $result = $command->execute();
        return $result;
    }
    public function findBranch($department_id){
        $db = \Yii::$app->db;
        $sql = "select * from pnl_department where ID in (select parent from pnl_department where ID=:department_id)";
        $command = $db->createCommand($sql);
        $command->bindValue(':department_id',$department_id);
        $result = $command->queryAll();
        return $result;
    }


    /** **************************************************
    *            ListBox For Department Form   Ends      *
    ******************************************************/
}
