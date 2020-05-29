<?php

use common\helper\Constants;
use yii\helpers\Html;
use common\helper\ImageUrls;

/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t(Constants::APP, 'site.view.my_shops');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="restaurant-index">

        <h1><?=Html::encode($this->title)?></h1>
        <p>
            <?=Html::a(Yii::t(Constants::APP, 'shop.add_shop'), ['create'], ['class' => 'btn btn-success'])?>
        </p>
        </br>
        <div class="row p-b-24">
            <?php
            $counter = 0;
            foreach ($dataProvider as $obj) {
                if ($counter > 2) {
                    echo "</div><div class='row p-b-24'>";
                    $counter = 0;
                }
                $counter++;
                ?>
                <div class="col-lg-4 col-sm-6">
                    <div class="card">
                        <!--Card image-->
                        <div class="view overlay">
                            <img class="shopCardPic img-fluid"
                                 src="<?=ImageUrls::FRONTEND_UPLOADS_SHOPS . $obj->picture?>"
                                 alt="">
                        </div>
                        <div class="card-bodyhome">
                            <!--Card content-->
                            <div class="card-body">
                                <!--Title-->
                                <h4 class="card-title text-center"><?=$obj->name?>
                                    <?php
                                    if ($obj->status == "active") {
                                        ?>
                                        <img class="pl" src="<?=ImageUrls::BULLET_GREEN?>"/>
                                    <?php } else {
                                        ?>
                                        <img class="pl" src="<?=ImageUrls::BULLET_RED?>"/>
                                    <?php } ?>
                                </h4>
                                <!--Text-->
                                <ul class="list-group">
                                    <div class="row">
                                        <li class="list-group-item col-sm-4"><a
                                                    href="/category/index/<?=$obj->id?>"><?=Yii::t(Constants::APP, 'category.title')?></a>
                                        </li>
                                        <li class="list-group-item col-sm-4"><a
                                                    href="/item/index/<?=$obj->id?>"><?=Yii::t(Constants::APP, 'item.title')?></a>
                                        </li>
                                    </div>
                                </ul>

                                <div class="icons col-md-12 text-right" style="">
                                    <div id="spaceup">
                                        <a href="/shop/view/<?=$obj->id?>"
                                           title="View" aria-label="View" data-pjax="0">
                                            <span class="glyphicon glyphicon-eye-open action"></span>
                                        </a>

                                        <a href="/shop/<?=$obj->id?>" title="Update"
                                           aria-label="Update" data-pjax="0">
                                            <span class="glyphicon glyphicon-pencil action"></span>
                                        </a>

                                        <a href="/shop/delete?id=<?=$obj->id?>"
                                           title="Delete"
                                           aria-label="Delete" data-pjax="0"
                                           data-confirm="Are you sure you want to delete this item?" data-method="post">
                                            <span class="glyphicon glyphicon-trash action"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
