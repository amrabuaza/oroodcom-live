<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\family\search\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Persons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">

    <h1><?=Html::encode($this->title)?></h1>

    <p>
        <?=Html::a('Create Person', ['create'], ['class' => 'btn btn-success'])?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            //'picture',
            //'category_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);?>


</div>
