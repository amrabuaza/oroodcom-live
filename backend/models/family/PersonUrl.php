<?php

namespace backend\models\family;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $url
 * @property string $title
 * @property int $person_id
 *
 */
class PersonUrl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person_url';
    }

    public function rules()
    {
        return [
            [['image', 'title', 'person_id'], 'required'],
            [['image', 'title'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => "Url",
            'title' => "Title",
            'person_id' => 'Person',
        ];
    }
}