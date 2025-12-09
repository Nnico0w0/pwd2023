<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Materias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="materia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar esta materia?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            [
                'attribute' => 'id_carrera',
                'value' => $model->carrera ? $model->carrera->nombre : '-',
                'label' => 'Carrera'
            ],
            [
                'attribute' => 'id_profesor',
                'value' => $model->profesor ? $model->profesor->mostrar : '-',
                'label' => 'Profesor'
            ],
            'cant_alumnos',
        ],
    ]) ?>

    <h3 class="mt-4">Reservas de aulas para esta materia</h3>
    <?php if ($model->reservas): ?>
        <ul>
            <?php foreach ($model->reservas as $reserva): ?>
                <li>
                    <?= Html::a(
                        $reserva->aula->descripcion . ' - ' . $reserva->fh_desde . ' hasta ' . $reserva->fh_hasta, 
                        ['/reserva-aula/view', 'id' => $reserva->id]
                    ) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No tiene reservas de aulas.</p>
    <?php endif; ?>

</div>
