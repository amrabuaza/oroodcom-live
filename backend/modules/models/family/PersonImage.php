<?php

namespace backend\modules\family;


/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $image
 * @property int $person_id
 *
 */
class PersonImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person_image';
    }

    public function rules()
    {
        return [
            [['image', 'person_id'], 'required'],
            [['image',], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => "image",
            'person_id' => 'Person',
        ];
    }
}