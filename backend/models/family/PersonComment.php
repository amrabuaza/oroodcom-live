<?php


namespace backend\models\family;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $comment
 * @property string $created_at
 * @property int $person_id
 *
 */
class PersonComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person_comment';
    }

    public function rules()
    {
        return [
            [['comment', 'person_id'], 'required'],
            [['comment'], 'string', 'max' => 255],
            [['created_at'], 'safe'],
            [['id'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment' => "Comment",
            'created_at' => "Created At",
            'person_id' => 'Person',
        ];
    }
}