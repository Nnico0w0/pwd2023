<?php

use yii\helpers\Html;

$this->title = 'Crear Reserva';
$this->params['breadcrumbs'][] = ['label' => 'Reservas de Aulas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-aula-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
