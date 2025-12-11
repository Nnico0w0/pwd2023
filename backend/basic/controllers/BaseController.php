<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use app\filters\AdminFilter;

class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Solo usuarios autenticados
                    ],
                ],
            ],
            'adminFilter' => [
                'class' => AdminFilter::class,
            ],
        ];
    }
}