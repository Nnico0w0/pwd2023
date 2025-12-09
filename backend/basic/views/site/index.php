<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Backoffice - Sistema de Gestión Universitaria';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-primary text-white rounded mb-5 p-5">
        <h1 class="display-4">🎓 Sistema de Gestión Universitaria</h1>
        <p class="lead">Panel de Administración</p>
        <p>Bienvenido, <strong><?= Yii::$app->user->identity->username ?></strong></p>
    </div>

    <div class="body-content">
        <h2 class="mb-4">Gestión de Recursos</h2>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-1 mb-3">📚</div>
                        <h3 class="card-title">Carreras</h3>
                        <p class="card-text">Administra los programas académicos de la universidad</p>
                        <?= Html::a('Gestionar Carreras', ['carrera/index'], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-1 mb-3">📖</div>
                        <h3 class="card-title">Materias</h3>
                        <p class="card-text">Gestiona las asignaturas y cursos disponibles</p>
                        <?= Html::a('Gestionar Materias', ['materia/index'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-1 mb-3">👨‍🏫</div>
                        <h3 class="card-title">Profesores</h3>
                        <p class="card-text">Administra el personal docente</p>
                        <?= Html::a('Gestionar Profesores', ['profesor/index'], ['class' => 'btn btn-info']) ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-1 mb-3">🏫</div>
                        <h3 class="card-title">Aulas</h3>
                        <p class="card-text">Gestiona los espacios físicos disponibles</p>
                        <?= Html::a('Gestionar Aulas', ['aula/index'], ['class' => 'btn btn-warning']) ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-1 mb-3">📅</div>
                        <h3 class="card-title">Reservas de Aulas</h3>
                        <p class="card-text">Administra las reservas y ocupación</p>
                        <?= Html::a('Gestionar Reservas', ['reserva-aula/index'], ['class' => 'btn btn-danger']) ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-1 mb-3">👤</div>
                        <h3 class="card-title">Usuarios</h3>
                        <p class="card-text">Gestiona los usuarios del sistema</p>
                        <?= Html::a('Gestionar Usuarios', ['usuario/index'], ['class' => 'btn btn-secondary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2) !important;
}

.jumbotron {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
