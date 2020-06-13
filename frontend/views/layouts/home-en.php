<?php

/* @var $this \yii\web\View */

/* @var $content string */

use frontend\assets\HomeAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\helper\Constants;

HomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
    <meta charset="<?=Yii::$app->charset?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?=Html::encode($this->title)?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $label = "English";
    if (Yii::$app->language == "en-US") {
        $label = "العربية";
    }
    $menuItems = [
        ['label' => $label, 'options' => ['class' => 'lang-item']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t(Constants::APP,"site.view.sign_up"), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => Yii::t(Constants::APP,"site.view.login"), 'url' => ['site/login']];
    } else {
        $menuItems[] = ['label' => Yii::t(Constants::APP,"site.view.my_shops"), 'url' => ['/shop']];
        $menuItems[] = [
            'label' => '' . Yii::$app->user->identity->username,
            'items' => [
                ['label' => Yii::t(Constants::APP,"site.view.profile"), 'url' => '/my-profile'],
                ['label' => Yii::t(Constants::APP, "nav.logout"), 'url' => '#','options' => ['class' => 'logout-btn']],
            ],
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?=Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])?>
        <?=Alert::widget()?>
        <?=$content?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?=Html::encode(Yii::$app->name)?> <?=date('Y')?></p>

        <p class="pull-right"><?="Powered by  <a href='https://www.facebook.com/ammar.o.alkhateeb' target='_blank'>Ammar</a>"?></p>
    </div>
</footer>
<?php
if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
