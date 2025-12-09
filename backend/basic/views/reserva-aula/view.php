<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Reserva #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reservas de Aulas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-aula-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar esta reserva?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'id_aula',
                'value' => $model->aula ? $model->aula->descripcion : '-',
                'label' => 'Aula'
            ],
            'fh_desde',
            'fh_hasta',
            'observacion:ntext',
        ],
    ]) ?>

    <h3 class="mt-4">Materias en esta reserva</h3>
    <?php if ($model->materias): ?>
        <ul>
            <?php foreach ($model->materias as $materia): ?>
                <li><?= Html::a($materia->nombre, ['/materia/view', 'id' => $materia->id]) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No tiene materias asignadas.</p>
    <?php endif; ?>

</div>
