<?php

use common\helper\Constants;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Shop */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t(Constants::APP, 'site.view.my_shops'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="shop-view">

    <h1><?=Html::encode($this->title)?></h1>

    <p>
        <?=Html::a(Yii::t(Constants::APP, 'buttons.update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])?>
        <?=Html::a(Yii::t(Constants::APP, 'buttons.delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])?>
    </p>

    <?=DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'phone_number',
            'description',
            'open_at',
            'close_at',
            'rate',
            [
                'attribute' => Yii::t(Constants::APP, 'shop.fields.status'),
                'value' => function ($model) {
                    if (Yii::$app->language == Constants::DEFAULT_LANGUAGE) {
                        return $model->status;
                    } else {
                        return $model->status == "inactive" ? "غير مفعل" : "فعال";
                    }
                },
            ],
        ],
    ])?>

    <?php
    echo \pigolab\locationpicker\LocationPickerWidget::widget([
        'key' => 'AIzaSyBaSSGZhnqDf3-jB7zJYXGiS5JCjTNL4U0',    // optional , Your can also put your google map api key
        'options' => [
            'style' => 'width: 100%; height: 400px', // map canvas width and height
        ],
        'clientOptions' => [
            'location' => [
                'latitude' => $model->latitude,
                'longitude' => $model->longitude,
            ],
            'radius' => 300,
            'inputBinding' => [
                'latitudeInput' => new JsExpression("$('#us2-lat')"),
                'longitudeInput' => new JsExpression("$('#us2-lon')"),
                'radiusInput' => new JsExpression("$('#us2-radius')"),
                'locationNameInput' => new JsExpression("$('#us2-address')")
            ]
        ]
    ]);
    ?>

</div>
