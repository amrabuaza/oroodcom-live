<?php

namespace backend\models\family;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $name
 * @property string|null $mother_name
 * @property string|null $birth_date
 * @property string|null $avatar
 * @property string|null $nickname
 * @property int $is_live
 * @property int $is_root
 * @property int|null $parent_id
 *
 * @property Person $parent
 * @property Person[] $people
 * @property PersonComment $personComment
 * @property PersonImage[] $personImages
 * @property PersonUrl[] $personUrls
 */
class Person extends \yii\db\ActiveRecord
{
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
            [['name', 'is_live', 'is_root'], 'required'],
            [['birth_date'], 'safe'],
            [['is_live', 'is_root', 'parent_id'], 'integer'],
            [['name', 'mother_name', 'avatar', 'nickname'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'mother_name' => Yii::t('app', 'Mother Name'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'avatar' => Yii::t('app', 'Avatar'),
            'nickname' => Yii::t('app', 'Nickname'),
            'is_live' => Yii::t('app', 'Is Live'),
            'is_root' => Yii::t('app', 'Is Root'),
            'parent_id' => Yii::t('app', 'Parent ID'),
        ];
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Person::className(), ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[People]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::className(), ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[PersonComment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonComment()
    {
        return $this->hasOne(PersonComment::className(), ['id' => 'id']);
    }

    /**
     * Gets query for [[PersonImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonImages()
    {
        return $this->hasMany(PersonImage::className(), ['person_id' => 'id']);
    }

    /**
     * Gets query for [[PersonUrls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonUrls()
    {
        return $this->hasMany(PersonUrl::className(), ['person_id' => 'id']);
    }
}
