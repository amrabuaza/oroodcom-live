<?php

namespace backend\modules\controllers;

use backend\models\family\search\PersonSearch;
use backend\models\translations\ItemLanguage;
use backend\models\family\Person;
use backend\modules\models\Item;
use backend\modules\models\SearchModel;
use common\behaviors\ApiResponseBehavior;
use common\helper\ApiHelper;
use common\helper\Constants;
use frontend\models\SearchItem;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\rest\ActiveController;
use yii\web\Response;

class PersonController extends ActiveController
{

    public $modelClass = 'backend\models\family\Person';

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
        //unset($actions['index']);
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

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-latest-items' => ['GET'],
                'filter' => ['POST'],
                'get-item-picture' => ['GET'],
            ]
        ];


        $behaviors['apiResponse'] = [
            'class' => ApiResponseBehavior::className(),
        ];

        return $behaviors;
    }

    public function actionTest()
    {
        return "test";
    }

    public function actionGetAll()
    {
        $query = Person::find()->where(["id" => "1"])->one();

//        foreach ($query as $person) {
//            try {
//                $person['parents_s'] = Person::find()->where(["parent_id" => $person->id])->all();
//            } catch (\Exception $exception) {
//                return $exception->getMessage();
//            }
//        }
        return $query;
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
//        return $query;
    }
}