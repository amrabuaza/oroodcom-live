<?php

namespace backend\models\family;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $name
 * @property string $mother_name
 * @property string $birth_date
 * @property string $nickname
 * @property int $is_live
 * @property int $is_root
 * @property int $parent_id
 * @property Person[] $parents
 *
 */
class Person extends \yii\db\ActiveRecord
{
    public $parents_s;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id', 'is_live', 'is_root', 'parent_id'], 'integer'],
            [['name', 'mother_name', 'nickname'], 'string', 'max' => 255],
            [['birth_date'], 'safe'],
            [['id'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => "Name",
            'mother_name' => 'Mother Name',
            'is_live' => 'Is Live',
            'is_root' => 'Is Root',
            'birth_date' => 'Birth Date',
            'parent_id' => 'Parent',
            'nickname' => 'nickname',
        ];
    }

    public function getParents()
    {
        return $this->hasMany(Person::className(), ['parent_id' => 'id']);
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields["parent_id"]);
        unset($fields["avatar"]);
        $fields['childs'] = function ($model) {
            return $this->parents;
        };
        return $fields;
    }

}