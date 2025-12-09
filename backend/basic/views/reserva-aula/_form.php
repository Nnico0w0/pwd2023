<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Aula;
use app\models\Materia;

?>

<div class="reserva-aula-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_aula')->dropDownList(
        ArrayHelper::map(Aula::find()->all(), 'id', 'descripcion'),
        ['prompt' => 'Seleccionar Aula']
    ) ?>

    <?= $form->field($model, 'fh_desde')->textInput(['type' => 'datetime-local']) ?>

    <?= $form->field($model, 'fh_hasta')->textInput(['type' => 'datetime-local']) ?>

    <?= $form->field($model, 'materia_ids')->dropDownList(
        ArrayHelper::map(Materia::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Seleccionar Materia']
    )->label('Materia') ?>

    <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
