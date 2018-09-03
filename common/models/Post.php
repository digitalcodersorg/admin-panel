<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%posts}}".
 *
 * @property string $ID
 * @property string $post_content
 * @property string $post_url
 * @property string $post_thumbnail
 * @property string $post_type
 * @property string $post_title
 * @property string $post_status
 * @property string $comment_status
 * @property string $post_parent
 * @property int $menu_order
 * @property string $comment_count
 * @property string $post_author
 * @property string $post_date
 * @property string $created_on
 * @property string $updated_on
 * @property string $created_by
 * @property string $updated_by
 *
 * @property Postmeta[] $postmetas
 * @property CmsUser $createdBy
 * @property CmsUser $updatedBy
 * @property Post $postParent
 * @property Post[] $posts
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%posts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_content', 'post_title'], 'string'],
            [['post_parent', 'menu_order', 'comment_count', 'created_by', 'updated_by'], 'integer'],
            [['post_date', 'created_on', 'updated_on'], 'safe'],
            [['post_url', 'post_thumbnail', 'post_author'], 'string', 'max' => 255],
            [['post_type'], 'string', 'max' => 50],
            [['post_status', 'comment_status'], 'string', 'max' => 20],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['post_parent'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_parent' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'post_content' => Yii::t('app', 'Post Content'),
            'post_url' => Yii::t('app', 'Post Url'),
            'post_thumbnail' => Yii::t('app', 'Post Thumbnail'),
            'post_type' => Yii::t('app', 'Post Type'),
            'post_title' => Yii::t('app', 'Post Title'),
            'post_status' => Yii::t('app', 'Post Status'),
            'comment_status' => Yii::t('app', 'Comment Status'),
            'post_parent' => Yii::t('app', 'Post Parent'),
            'menu_order' => Yii::t('app', 'Menu Order'),
            'comment_count' => Yii::t('app', 'Comment Count'),
            'post_author' => Yii::t('app', 'Post Author'),
            'post_date' => Yii::t('app', 'Post Date'),
            'created_on' => Yii::t('app', 'Created On'),
            'updated_on' => Yii::t('app', 'Updated On'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
    public function searchPost($queryParams){
        return static::find()->all();
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostmetas()
    {
        return $this->hasMany(Postmeta::className(), ['post_id' => 'ID']);
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
    public function getPostParent()
    {
        return $this->hasOne(Post::className(), ['ID' => 'post_parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['post_parent' => 'ID']);
    }
}
