<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="aula-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ubicacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cant_proyector')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'aforo')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'es_climatizada')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
