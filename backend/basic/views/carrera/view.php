<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Carrera $model */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Carreras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrera-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar esta carrera?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
        ],
    ]) ?>

    <h3 class="mt-4">Materias de la carrera</h3>
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
