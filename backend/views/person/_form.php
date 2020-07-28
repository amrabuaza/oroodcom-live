<?php

use backend\models\Category;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'mother_name')->textInput()?>

    <?=$form->field($model, 'nickname')->textInput()?>

    <?=$form->field($model, 'is_live')->textInput(['maxlength' => true])?>
    <?=$form->field($model, 'is_root')->textInput(['maxlength' => true])?>


    <?=
    $form->field($model, 'parent_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\backend\models\family\Person::find()->all(), 'id', 'name'),
        'language' => Yii::$app->language,
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label("Perant Person");
    ?>

    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
