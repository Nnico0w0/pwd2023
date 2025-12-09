<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Reservas de Aulas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-aula-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Reserva', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'id_aula',
                'value' => function($model) {
                    return $model->aula ? $model->aula->descripcion : '-';
                },
                'label' => 'Aula'
            ],
            [
                'label' => 'Materias',
                'value' => function($model) {
                    $materias = [];
                    foreach ($model->horarioMaterias as $horario) {
                        if ($horario->materia) {
                            $materias[] = $horario->materia->nombre;
                        }
                    }
                    return !empty($materias) ? implode(', ', $materias) : '-';
                }
            ],
            'fh_desde',
            'fh_hasta',
            'observacion:ntext',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
