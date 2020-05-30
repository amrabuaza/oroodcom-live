<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\helper\Constants;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <div class="container" id="top-container">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-default panel_login body_login">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="brand wow fadeIn">
                                    <h1 class="brand_name">
                                        <a href="/home">Oroodcom</a>
                                        <hr/>
                                    </h1>
                                </div>
                                <h2 class="welcome_mes"><?=Yii::t(Constants::APP, "site.login.welcome")?></h2>
                                <br/>
                                <br/>
                                <br/>
                                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                                <?=$form->field($model, 'username')->textInput(['autofocus' => true])?>

                                <?=$form->field($model, 'password')->passwordInput()?>

                                <?=$form->field($model, 'rememberMe')->checkbox()?>

                                <div class="form-group login-bt">
                                    <?=Html::submitButton(Yii::t(Constants::APP, "site.view.login"), ['class' => 'btn btn-default', 'name' => 'login-button'])?>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>

