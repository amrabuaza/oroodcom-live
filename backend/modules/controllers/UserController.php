<?php

namespace backend\modules\controllers;

use backend\modules\models\UserModels\ChangePassword;
use backend\modules\models\UserModels\UserProfile;

use common\behaviors\ApiResponseBehavior;
use common\helper\ApiHelper;
use yii\filters\RateLimiter;
use yii\web\Response;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;

class UserController extends ActiveController
{
    public $modelClass = 'backend\models\User';

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
                'Access-Control-Request-Method' => ['POST', 'GET', 'PATCH', 'PUT'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['options', 'send-code'],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-user-profile' => ['GET'],
                'update-user' => ['PUT'],
                'change-password' => ['PATCH'],
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


    public function actionGetUserProfile()
    {
        return UserProfile::getUserByAccessToken(ApiHelper::getAccessTokenFromHeaders(Yii::$app->request));
    }

    public function actionUpdateUser()
    {
        $model = new UserProfile();
        $model->access_token = ApiHelper::getAccessTokenFromHeaders(Yii::$app->request);

        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            $result = $model->update();
            if (!$result['status']) {
                Yii::$app->response->statusCode = 400;
                return ['messages' => $result['user']];
            }
            return $result['user'];

        } else {
            Yii::$app->response->statusCode = 400;
            $model->validate();
            return ['messages' => $model];
        }
    }

    public function actionChangePassword()
    {
        $model = new ChangePassword();
        $model->access_token = ApiHelper::getAccessTokenFromHeaders(Yii::$app->request);

        if ($model->load(Yii::$app->request->post(), '')) {
            if ($model->save()) {
                return "done";
            } else if (!$model->validate()) {
                Yii::$app->response->statusCode = 400;
                return ['messages' => $model];
            } else {
                throw new BadRequestHttpException("Old password not match !!");
            }
        }
        $model->validate();
        return ['messages' => $model];
    }
}
