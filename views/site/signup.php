<?php

/** @var app\models\SignupForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<div class="form-group">
    <div>
        <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success', 'id' => 'submit-signup']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
