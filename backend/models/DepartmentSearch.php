<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Department;
use common\models\User;

/**
 * DepartmentSearch represents the model behind the search form of `common\models\Department`.
 */
class DepartmentSearch extends Department
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'address', 'parent', 'department_head', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'type', 'created_on', 'updated_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Department::find();
        $query->select([Department::tableName().'.*','u1.username as department_head_name']);
        // add conditions that should always apply here
        $query->leftJoin(User::tableName().' as u1 ', 'u1.id = '.Department::tableName().'.department_head');
        $this->load($params);

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'address' => $this->address,
//            'parent' => $this->parent,
//            'department_head' => $this->department_head,
//            'created_by' => $this->created_by,
//            'updated_by' => $this->updated_by,
//            'created_on' => $this->created_on,
//            'updated_on' => $this->updated_on,
        ]);

        $query->andFilterWhere(['like', Department::tableName().'.name', $this->name])
            ->andFilterWhere(['like', Department::tableName().'.description', $this->description])
            ->andFilterWhere(['like', Department::tableName().'.type', $this->type]);
        $query->orderBy([Department::tableName().'.updated_on'=>SORT_DESC]);
        return $query->createCommand()->queryAll();
    }
}
