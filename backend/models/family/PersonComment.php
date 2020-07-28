<?php

namespace backend\models\family;

use Yii;

/**
 * This is the model class for table "person_comment".
 *
 * @property int $id
 * @property string $comment
 * @property string $created_at
 * @property int $person_id
 *
 * @property Person $id0
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment', 'person_id'], 'required'],
            [['created_at'], 'safe'],
            [['person_id'], 'integer'],
            [['comment'], 'string', 'max' => 255],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'comment' => Yii::t('app', 'Comment'),
            'created_at' => Yii::t('app', 'Created At'),
            'person_id' => Yii::t('app', 'Person ID'),
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Person::className(), ['id' => 'id']);
    }
}
