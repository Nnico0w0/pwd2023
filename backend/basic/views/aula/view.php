<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Aulas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aula-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar esta aula?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
            'ubicacion',
            'cant_proyector',
            'aforo',
            'es_climatizada:boolean',
        ],
    ]) ?>

    <h3 class="mt-4">Reservas del aula</h3>
    <?php if ($model->reservaAulas): ?>
        <ul>
            <?php foreach ($model->reservaAulas as $reserva): ?>
                <li>
                    <?= Html::a(
                        'Reserva #' . $reserva->id . ' - ' . $reserva->fh_desde . ' hasta ' . $reserva->fh_hasta, 
                        ['/reserva-aula/view', 'id' => $reserva->id]
                    ) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No tiene reservas.</p>
    <?php endif; ?>

</div>
