<?php

namespace webvimark\modules\UserManagement\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use webvimark\modules\UserManagement\models\User;

/**
 * UserSearch represents the model behind the search form about `webvimark\modules\UserManagement\models\User`.
 */
class UserSearch extends User
{
    public $statesCode;
    public $directionDescr;

    public function rules()
    {
        return [
            [['id', 'superadmin', 'status', 'created_at', 'updated_at', 'email_confirmed', 'state_id', 'direction_id'], 'integer'],
            [['username', 'name', 'gridRoleSearch', 'registration_ip', 'email'], 'string'],
            [['statesCode', 'directionDescr'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();
        $query->joinWith(['states', 'direction']);
        $query->with(['roles']);

        if (!Yii::$app->user->isSuperadmin) {
            $query->where(['superadmin' => 0]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);
        // Важно: так мы определяем сортировку
        // Главное это имя аттрибута
        $dataProvider->sort->attributes['statesCode'] = [
            // Это те таблицы, с которыми у нас установлена связь
            'asc' => ['states.code' => SORT_ASC],
            'desc' => ['states.code' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['directionDescr'] = [
            // Это те таблицы, с которыми у нас установлена связь
            'asc' => ['user_direction.descr' => SORT_ASC],
            'desc' => ['user_direction.descr' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->gridRoleSearch) {
            $query->joinWith(['roles']);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'superadmin' => $this->superadmin,
            'status' => $this->status,
            'direction_id' => $this->direction_id,
            Yii::$app->getModule('user-management')->auth_item_table . '.name' => $this->gridRoleSearch,
            'registration_ip' => $this->registration_ip,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'email_confirmed' => $this->email_confirmed,
            'state_id' => $this->state_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'states.code', $this->statesCode])
            ->andFilterWhere(['like', 'user_direction.descr', $this->directionDescr]);

        return $dataProvider;
    }
}
