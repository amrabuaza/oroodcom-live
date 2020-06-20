<?php

namespace backend\models\translations;

use backend\models\Category;
use backend\models\translations\ShopLanguage;
use backend\models\User;
use common\helper\Constants;
use omgdef\multilingual\MultilingualBehavior;
use Yii;


/**
 * This is the model class for table "shop".
 *
 * @property int $id
 * @property string $name
 * @property int $phone_number
 * @property string $description
 * @property string $latitude
 * @property string $longitude
 * @property string $open_at
 * @property string $close_at
 * @property int $rate
 * @property string $picture
 * @property string $status
 * @property int $owner_id
 *
 * @property Category[] $categories
 * @property User $owner
 * @property ShopLanguage $shopLanguage
 */
class Shop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop';
    }

    public $address;
    public $upload_image;

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->address)) {
                $part = explode("@", $this->address);
                if (count($part) == 2) {
                    $this->latitude = $part[0];
                    $this->longitude = $part[1];
                }
            }
            if ($this->isNewRecord) {
                $this->owner_id = Yii::$app->user->id;
                $this->rate = 5;
            }

            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone_number', 'description', 'open_at', 'close_at', 'picture'], 'required'],
            [['phone_number', 'rate', 'owner_id'], 'integer'],
            [['status'], 'string'],
            [['address'], 'safe'],
            [['upload_image'], 'safe'],
            [['name',  'description', 'latitude', 'longitude', 'open_at', 'close_at', 'picture'], 'string', 'max' => 255],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t(Constants::APP, "shop.fields.name"),
            'phone_number' => Yii::t(Constants::APP, "shop.fields.phone_number"),
            'description' => Yii::t(Constants::APP, "shop.fields.description"),
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'open_at' => Yii::t(Constants::APP, "shop.fields.open_at"),
            'close_at' => Yii::t(Constants::APP, "shop.fields.close_at"),
            'rate' => Yii::t(Constants::APP, "shop.fields.rate"),
            'picture' => 'Picture',
            'status' => 'Status',
            'owner_id' => 'Owner ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['shop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * Gets query for [[ShopLanguage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShopLanguage()
    {
        return $this->hasOne(ShopLanguage::className(), ['shop_id' => 'id']);
    }
}
