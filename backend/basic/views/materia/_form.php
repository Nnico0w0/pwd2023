<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Carrera;
use app\models\Profesor;

?>

<div class="materia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_carrera')->dropDownList(
        ArrayHelper::map(Carrera::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Seleccione una carrera']
    ) ?>

    <?= $form->field($model, 'id_profesor')->dropDownList(
        ArrayHelper::map(Profesor::find()->all(), 'id', 'mostrar'),
        ['prompt' => 'Seleccione un profesor']
    ) ?>

    <?= $form->field($model, 'cant_alumnos')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
