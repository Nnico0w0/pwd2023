<?php

use yii\helpers\Html;

$this->title = 'Actualizar Reserva: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reservas de Aulas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="reserva-aula-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
