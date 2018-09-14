<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%todo}}".
 *
 * @property string $ID
 * @property string $text
 * @property string $status
 * @property string $created_on
 * @property string $created_by
 * @property string $updated_on
 */
class Todo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%todo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'status'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['created_by'], 'integer'],
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
            'status' => Yii::t('app', 'Status'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_on' => Yii::t('app', 'Updated On'),
        ];
    }
    public static function getTodo($uid , $page){
        $list = Todo::find();
            $list->where(['created_by'=>$uid]);
            $page = isset($page) ? (int) $page : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $total_count = $list->count();
            $data = $list->limit($limit)
                ->offset($offset)
                ->orderBy(['updated_on' => SORT_DESC])
                ->asArray()
                ->all();
            return ['data'=>$data, 'count'=>$total_count];
    }
    public static function insertTodo($post){
        $todo = new Todo();
        $todo->text = $post['text'];
        $todo->status = 'pending';
        $todo->created_by = $post['user'];
        $todo->created_on = date('Y-m-d H:i:s');
        $todo->updated_on = date('Y-m-d H:i:s');
        if($todo->validate()){
            $todo->save();
            return $todo->ID;
        }
        return false;
    }
    public static function updateTodo($post){
        $todo = Todo::findOne($post['ID']);
        $todo->text = ($post['text'] != $todo->text) ? $post['text'] : $todo->text;
        $todo->status = ($post['status'] == "") ? $todo->status : $post['status'];
        $todo->updated_on = date('Y-m-d H:i:s');
        if($todo->validate()){
            $todo->save();
            return true;
        }
        return false;
    }
    public static function deleteTodo($post){
            $db = \Yii::$app->db;
            $sql = "delete from pnl_todo where created_by = :user and ID = :id";
            $command = $db->createCommand($sql);
            $command->bindValue(':user', $post['user']);
            $command->bindValue(':id', $post['ID']);
            $result = $command->execute();
            return $result;
    }
}
