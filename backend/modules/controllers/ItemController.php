<?php

namespace backend\modules\controllers;

use backend\models\translations\ItemLanguage;
use backend\modules\models\Item;
use backend\modules\models\SearchModel;
use common\behaviors\ApiResponseBehavior;
use common\helper\ApiHelper;
use common\helper\Constants;
use frontend\models\SearchItem;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\rest\ActiveController;
use yii\web\Response;

class ItemController extends ActiveController
{

    public $modelClass = 'backend\modules\models\Item';

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action))
            return false;

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->language = ApiHelper::getLanguageFromHeaders(Yii::$app->request);
        return true;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['view']);
        unset($actions['delete']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['options'],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-latest-items' => ['GET'],
                'filter' => ['POST'],
                'get-item-picture' => ['GET'],
            ]
        ];

//        $behaviors['contentNegotiator'] = [
//            'class' => ContentNegotiator::className(),
//            'formats' => [
//                'application/json' => Response::FORMAT_JSON,
//                'application/xml' => Response::FORMAT_XML,
//            ],
//        ];

        $behaviors['apiResponse'] = [
            'class' => ApiResponseBehavior::className(),
        ];

        return $behaviors;
    }


    public function actionGetLatestItems()
    {
        $query = Item::find()->orderBy(['id' => SORT_DESC])->limit(10);
        $items = $query->joinWith("shop")->where(["shop.status" => "active"])->all();
        return ['items' => $items];

    }

    public function actionGetItemsName()
    {
        return ['names' => ApiHelper::getItemsNameDistinct()];
    }

    public function actionGetItemPicture($id)
    {
        $pictureUrl = Item::findOne($id)->picture;
        $contentType = 'image/jpeg';
        $filePath = "http://oroodcom.com/uploads/items/" . $pictureUrl;
        $response = Yii::$app->getResponse();
        $response->headers->set('Content-Type', $contentType);
        $response->format = Response::FORMAT_RAW;
        if (!is_resource($response->stream = fopen($filePath, 'r'))) {
            throw new \yii\web\ServerErrorHttpException('file access failed: permission deny');
        }
        return $response->send();
    }


    public function actionFilter()
    {
        $model = new SearchItem();

        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            $searchModel = new SearchModel();
            if (Yii::$app->language == Constants::ARABIC_LANGUAGE) {
                $lang = Yii::$app->language;
                Yii::$app->language = Constants::DEFAULT_LANGUAGE;
                $item = ItemLanguage::findOne(['like', 'name', $model->item_name]);
                if ($item != null) {
                    $searchModel->name = Item::findOne($item->item_id)->name;
                } else {
                    unset($searchModel->name);
                }

                Yii::$app->language = $lang;
            } else {
                $searchModel->name = $model->item_name;
            }

            if (isset($model->shop_rate)) {
                $searchModel->shopRate = $model->shop_rate;
            }

            if (isset($model->lowest_price)) {
                $searchModel->lowestPrice = $model->lowest_price;
            } else {
                $searchModel->lowestPrice = 0;
            }

            if (isset($model->longitude) && isset($model->latitude)) {
                $searchModel->longitude = $model->longitude;
                $searchModel->latitude = $model->latitude;
                $searchModel->nearByShop = 1;
            } else {
                $searchModel->nearByShop = 0;
            }

            return ['items' => $searchModel->search(Yii::$app->request->queryParams)->models];
        } else {
            $model->validate();
            return ['messages' => $model];
        }


    }

}