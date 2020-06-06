<?php

namespace backend\modules\controllers;

use common\behaviors\ApiResponseBehavior;
use common\helper\ApiHelper;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\Response;

class CategoryController extends ActiveController
{

    public $modelClass = 'backend\models\Category';

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
                'get-names' => ['GET'],
                'filter' => ['GET'],
            ]
        ];

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML,
            ],
        ];

        $behaviors['apiResponse'] = [
            'class' => ApiResponseBehavior::className(),
        ];

        return $behaviors;
    }

    public function actionGetNames()
    {
        return ['names' => ApiHelper::getCategoriesDistinct()];
    }

    public function actionFilter($id)
    {
        if (\backend\models\Category::findOne($id) == null) {
            return ['field' => 'id', 'messages' => "not valid id"];
        }
        return ['items' => ApiHelper::filterItemsByCategoryId($id)];
    }

}