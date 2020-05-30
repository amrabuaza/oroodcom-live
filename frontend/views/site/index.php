<?php

use backend\models\Category;
use common\helper\ApiHelper;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helper\Constants;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use common\helper\ImageUrls;

/* @var $this yii\web\View */
/* @return mixed
 * @var $dataProvider yii\data\ActiveDataProvider
 */
/* @var $pages yii\data\Pagination */

$this->title = 'Oroodcom';
?>

<div class="container">
    <?php Pjax::begin(); ?>
    <div class="form-group">
        <?=Html::submitButton(Yii::t(Constants::APP, 'site.index.search'), ['value' => Url::to(['/site/filter-items']), "method" => "post", 'class' => 'filter-btn btn btn-primary'])?>
    </div>

    <?php
    Modal::begin([
        'header' => '<h4 class="text-center">' . Yii::t(Constants::APP, 'site.index.search') . '</h4>',
        'id' => 'myModal',
        'size' => 'modal-sm',
    ]);

    echo "<div id='myModalContent'></div>";

    Modal::end();

    ?>

    <div class="site-wrapper">

        <div class="grid">

            <div id="shopify-section-sidebar" class="shopify-section">
                <div data-section-id="sidebar" data-section-type="sidebar-section">
                    <nav class="hide-on-mobile grid__item small--text-center medium-up--one-fifth" role="navigation">
                        <hr class="hr--small medium-up--hide">
                        <div id="SiteNav" class="site-nav" role="menu" style="">
                            <ul class="list--nav">
                                <?php
                                $categories = ApiHelper::getCategoriesDistinct();
                                foreach ($categories as $category) {
                                    ?>
                                    <li class="site-nav__item site-nav--active">
                                        <a href="/site/filter/<?=$category->id?>"
                                           class="site-nav__link" aria-current="page"><?=$category->name?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <hr class="medium-up--hide hr--small hr--border-bottom">
                    </nav>
                </div>
            </div>

            <main class="main-content grid__item medium-up--four-fifths" id="MainContent" role="main">


                <div class="index-sections">
                    <!-- BEGIN content_for_index -->
                    <div id="shopify-section-featured-products" class="shopify-section">
                        <hr class="medium-up--hide hr--clear hr--small hide-on-mobile">
                        <div class="featured-products">
                            <h2 class="small--text-center"><?=Yii::t(Constants::APP, 'site.index.items')?></h2>
                            <div class="grid grid--uniform" role="list">

                                <div class="grid__item">
                                    <div class="grid grid--uniform">
                                        <?php
                                        foreach ($dataProvider as $obj) {
                                            $shop = $obj->shop;

                                            ?>
                                            <div class="grid__item product medium-up--one-third small--one-half">
                                                <div class="text-center">
                                                    <img class="item-pic img-fluid"
                                                         src="<?=ImageUrls::FRONTEND_UPLOADS_ITEMS . $obj->picture?>"
                                                         alt="">
                                                    <div class="product__title"><?=$obj->name?></div>
                                                    <div class="product__price"><strike
                                                                style="color:red">JD<?=$obj->old_price . " "?></strike>JD<?php echo $obj->price ?>
                                                    </div>
                                                </div>
                                                <div class="social-sharing__link"><?=$obj->description?></div>
                                                <br/>
                                                <div class="text-right"><a
                                                            href="/shop/info/<?=$shop->id?>"> <?=$shop->name?></a>
                                                </div>

                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?=LinkPager::widget([
            'pagination' => $pages,
        ]);?>
        <hr>
    </div>
    <?php Pjax::end(); ?>
</div>
