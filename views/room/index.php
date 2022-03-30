<?php

/** @var yii\web\View $this */

$this->title = 'Семестр 6';
$choice1 = "";
$choice2 = "";
if ($data[0]['first_choice'] == 1) {
    $choice1 = ' disabled style="background-color: red"';
}
if ($data[0]['second_choice'] == 1) {
    $choice2 = ' disabled style="background-color: red"';
}
?>
<div class="site-index">
    <?php /*<div id="wrapper">
        <button class="unit" id="unit1" <?=$choice1?>>

        </button>
        <button class="unit" id="unit2" <?=$choice2?>>

        </button>
    </div> */?>
    <h1 class="mid-h1" id="mid-h1">Выберите динозавра!</h1>
    <div class="game">
        <button id="unit1" class="unit dino"></button>
        <div id="cactus" class="cactus"></div>
    </div>
    <div class="game">
        <button id="unit2" class="unit dino"></button>
        <div id="cactus2" class="cactus"></div>
    </div>


</div>
<?php $this->registerJsFile('@web/js/game.js', [
    'depends' => 'yii\web\YiiAsset',
]); ?>