<?php

namespace backend\modules\controllers;

use backend\modules\models\family\Person;

use backend\modules\models\family\SinglePerson;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class PersonController extends ActiveController
{

    public $modelClass = 'backend\modules\models\family\Person';


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

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-all' => ['GET'],
                'get-childs-by-parent-id' => ['GET'],
                'update-user' => ['POST'],
                'create-user' => ['POST'],
            ]
        ];


        return $behaviors;
    }


    public function actionGetAll()
    {
        return Person::find()->where(["id" => "1"])->one();
    }

    public function actionGetChildsByParentId($id)
    {
        return SinglePerson::find()->where(["parent_id" => $id])->all();
    }

    public function actionCreateUser()
    {
        $model = new SinglePerson();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return $model;
        }
        $model->validate();
        return $model;
    }

    public function actionUpdateUser($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post(), "") && $model->save()) {
            return $model;
        }
        $model->validate();
        return $model;
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    public function actionFullView($id)
    {
        $model = SinglePerson::findOne($id);

        $childs = $this->actionGetChildsByParentId($id);
        return [
            "person" => $model,
            "childs" => $childs
        ];
    }

    public function actionDeleteChild($id)
    {
        return SinglePerson::findOne($id)->delete();
    }

    protected function findModel($id)
    {
        if (($model = SinglePerson::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}