<?php

namespace backend\modules\models;


use backend\models\Category;
use backend\models\translations\ItemLanguage;
use omgdef\multilingual\MultilingualBehavior;
use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $name
 * @property double $price
 * @property double $old_price
 * @property string $description
 * @property string $picture
 * @property int $category_id
 *
 * @property Category $category
 * @property Shop $shop
 */
class Item extends \yii\db\ActiveRecord
{
    public $file;
    public $upload_image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'old_price', 'description'], 'required'],
            [['id', 'category_id'], 'integer'],
            [['price', 'old_price'], 'number'],
            [['name', 'description', 'picture'], 'string', 'max' => 255],
            [['upload_image'], 'file', 'extensions' => 'png, jpg', 'skipOnEmpty' => true],
            [['id'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        $fields['picture'] = function ($model) {
            return "https://oroodcom.com/uploads/items/" . $this->picture;
        };

        $fields["shop"] = function ($model) {
            $shop = $this->shop;
            unset($shop->id);
            unset($shop->owner_id);
            unset($shop->status);
            return $shop;
        };

        return $fields;
    }

    public function behaviors()
    {
        return [
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params["languages"],
                'languageField' => 'language',
                'dynamicLangClass' => true,
                'langClassName' => ItemLanguage::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => 'en-US',
                'langForeignKey' => 'item_id',
                'tableName' => "{{%item_language}}",
                'attributes' => [
                    'name',
                    'description'
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price after sale',
            'old_price' => 'Old Price',
            'description' => 'Description',
            'picture' => 'Picture',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id'])->via("category");
    }
}
