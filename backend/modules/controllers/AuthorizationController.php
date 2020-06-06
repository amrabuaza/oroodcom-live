<?php

namespace backend\modules\controllers;

use backend\modules\models\SignupForm;
use backend\modules\models\UserModels\User;
use common\behaviors\ApiResponseBehavior;
use common\models\LoginForm;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;

class AuthorizationController extends Controller
{

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

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'login' => ['POST'],
                'signup' => ['POST']
            ]
        ];

        $behaviors['contentNegotiator']= [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML,
            ],
        ];

        $behaviors['apiResponse']= [
            'class' => ApiResponseBehavior::className(),
        ];

        return $behaviors;
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $model->type = "user";
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            $user = User::findOne(["username" => $model->username]);
            $user->generateAccessToken();
            $user->save();
            return ['access_token' => $user->access_token,'username'=>$user->username];
        }
        $model->validate();
        return ['messages'=>$model];

    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->signup()) {
            $user = User::findOne(["username" => $model->username]);
            return ['access_token' => $user->access_token,'username'=>$user->username];
        } else {
            Yii::$app->response->statusCode = 422;
            $model->validate();
            return ['messages'=>$model];
        }
    }

}