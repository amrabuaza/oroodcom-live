<?php

namespace common\helper;

use backend\models\Category;
use backend\models\User;
use backend\modules\models\Item;
use Yii;
use yii\db\Query;

abstract class ApiHelper
{
    public static function getLanguageFromHeaders($request)
    {
        if (isset($request->headers['Accept-Language'])) {
            return $request->headers['Accept-Language'];
        }
        return Yii::$app->language;
    }

    public static function getAccessTokenFromHeaders($request)
    {
        $authorization = $request->headers['authorization'];
        $authorization = explode(" ", $authorization);
        return $authorization[1];
    }

    public static function getUserFromRequest($request)
    {
        return User::findOne(["access_token" => ApiHelper::getAccessTokenFromHeaders($request)]);
    }

    public static function getUserFromToken($token)
    {
        return User::findOne(["access_token" => $token]);
    }

    public static function getCategoriesDistinct()
    {
        $language = Yii::$app->language;
        Yii::$app->language = Constants::DEFAULT_LANGUAGE;
        $result = [];
        $query = new Query();
        $categories = $query->select(['name'])
            ->from('category')
            ->distinct()
            ->all();
        Yii::$app->language = $language;
        foreach ($categories as $category) {
            $tempCategory = Category::findOne(['name' => $category['name']]);
            unset($tempCategory->shop_id);
            $result[] = $tempCategory;
        }
        return $result;
    }

    public static function filterItemsByCategoryId($id)
    {
        $language = Yii::$app->language;
        Yii::$app->language = Constants::DEFAULT_LANGUAGE;
        $name = Category::findOne($id)->name;
        $categories = Category::find()->where(['like', 'name', $name])->all();

        $query = Item::find();
        foreach ($categories as $category) {
            $query->orWhere(["category_id" => $category->id]);
        }

        $query->joinWith("shop");
        $query->andWhere(["shop.status" => "active"]);
        Yii::$app->language = $language;
        return $query->all();
    }


}