<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Aulas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aula-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Aula', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'descripcion',
            'ubicacion',
            'aforo',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
