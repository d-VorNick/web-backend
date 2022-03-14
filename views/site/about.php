<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Лабы';
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('./content/datatable', [
            'data' => $data,
            'request' => $request,
    ]); ?>
</div>
