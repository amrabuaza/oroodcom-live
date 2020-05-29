<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use common\helper\Constants;
use common\helper\ImageUrls;

$this->title = $name;
?>

<div class="center min-h-77 top-25">
    <div class="container">
        <img src="<?= ImageUrls::NOT_FOUND ?>" class="error-img">
        <h4 class="text-center"><?= Yii::t(Constants::APP, 'site.views.error.message_error') ?> </h4>
        <p class="text-center grayText">
            <?= Yii::t(Constants::APP, 'site.views.error.please_contact') ?>
        </p>
    </div>
</div>
