<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Materias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="materia-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Materia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nombre',
            [
                'attribute' => 'id_carrera',
                'value' => function($model) {
                    return $model->carrera ? $model->carrera->nombre : '-';
                },
                'label' => 'Carrera'
            ],
            [
                'attribute' => 'id_profesor',
                'value' => function($model) {
                    return $model->profesor ? $model->profesor->mostrar : '-';
                },
                'label' => 'Profesor'
            ],
            'cant_alumnos',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
