<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap4\Html;

$this->title = 'Игра';
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row rooms">

        <?php
            $counter = 0;
            foreach ($data as $d) {
                $src = '/img/' . $d['id'] . '.webp';
                $places = $d['first_place'] + $d['second_place'];
                $disabled1 = $d['first_place'] == 1 ? "" : "disabled";
                $disabled2 = $d['second_place'] == 1 ? "" : "disabled";
                ?>
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="<?=$src?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Комната № <?=$d['id']?></h5>
                        <p class="card-text">Свободных мест: <?=$places?></p>
                        <div class="row players">
                            <a href="#" id="<?=$d['id']+$counter?>" class="btn btn-primary btn-player <?=$disabled1?>"><?= $disabled1 == "" ? "Игрок 1" : "Занято"?></a>
                            <a href="#" id="<?=$d['id']+$counter+1?>" class="btn btn-primary btn-player <?=$disabled2?>"><?= $disabled2 == "" ? "Игрок 2" : "Занято"?></a>
                        </div>
                    </div>
                </div>
         <?php
                $counter = $counter + 1;
            }
        ?>

    </div>
    <div id="wrapper">
        <div class="unit" id="unit">

        </div>
    </div>
</div>
<?php $this->registerJsFile('@web/js/rooms.js', [
    'depends' => 'yii\web\YiiAsset',
]); ?>
