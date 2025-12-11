<?php

namespace app\controllers;

use yii\web\Controller;
use app\filters\AdminFilter;

class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'adminFilter' => [
                'class' => AdminFilter::class,
            ],
        ];
    }
}