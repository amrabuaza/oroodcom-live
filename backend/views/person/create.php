<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\family\Person */

$this->title = 'Create Person';
$this->params['breadcrumbs'][] = ['label' => 'Persons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">

    <h1><?=Html::encode($this->title)?></h1>

    <?=$this->render('_form', [
        'model' => $model,
    ])?>

</div>
