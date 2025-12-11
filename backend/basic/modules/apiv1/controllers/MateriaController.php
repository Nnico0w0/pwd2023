<?php

namespace app\modules\apiv1\controllers;

use app\models\Materia;
use yii\data\ActiveDataProvider;

class MateriaController extends BaseController
{
    public $modelClass = Materia::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $modelClass = $this->modelClass;
        return new ActiveDataProvider([
            'query' => $modelClass::find()->with(['carrera', 'profesor']),
            'pagination' => false,
        ]);
    }
}
