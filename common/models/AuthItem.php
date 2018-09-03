<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%auth_item}}".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $group_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property CmsUser[] $users
 * @property Group $groupName
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%auth_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'type'], 'required'],
            [['name'], 'unique'],
            [['type'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name', 'group_name'], 'string', 'max' => 64],
            [['group_name'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['group_name' => 'name']],
                /// [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'group_name' => 'Group Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments() {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasMany(CmsUser::className(), ['id' => 'user_id'])->viaTable('tbl_auth_assignment', ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupName() {
        return $this->hasOne(Group::className(), ['name' => 'group_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName() {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren() {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0() {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren() {
        return $this->hasMany(AuthItem::className(), ['name' => 'child'])->viaTable('tbl_auth_item_child', ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents() {
        return $this->hasMany(AuthItem::className(), ['name' => 'parent'])->viaTable('tbl_auth_item_child', ['child' => 'name']);
    }

    public function checkItemFormat($name = '') {
        $name = preg_replace('~[^\\pL\d]+~u', '-', $name);
        $name = trim($name, '-');
        $name = iconv('utf-8', 'us-ascii//TRANSLIT', $name);
        $name = strtolower($name);
        $name = preg_replace('~[^-\w]+~', '', $name);

        return $name;
    }

    public function search($params = "") {
        $db = \Yii::$app->db;
        $where = '';
        if (!empty($params['filter_name'])) {
            $where = 'and name like :filter_name';
        }
        $sql = "select * from  pnl_auth_item where type = 1 $where order by updated_at desc ";
        $command = $db->createCommand($sql);

        if (!empty($params['filter_name'])) {
            $command->bindValue(':filter_name', '%' . $params['filter_name'] . '%');
        }
        $result = $command->queryAll();
        return $result;
    }

}
