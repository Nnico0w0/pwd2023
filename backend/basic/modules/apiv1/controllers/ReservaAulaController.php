<?php

namespace app\modules\apiv1\controllers;

use app\models\ReservaAula;
use yii\data\ActiveDataProvider;

class ReservaAulaController extends BaseController
{
    public $modelClass = ReservaAula::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ReservaAula::find()->with(['aula', 'materias']),
            'pagination' => false,
        ]);

        return $dataProvider;
    }
}
