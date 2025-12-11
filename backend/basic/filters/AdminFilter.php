<?php

namespace app\filters;

use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
use Yii;

class AdminFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->loginRequired();
            return false;
        }
        
        $user = Yii::$app->user->identity;
        if (!$user || !$user->isAdmin()) {
            throw new ForbiddenHttpException('Solo los administradores pueden acceder a esta sección.');
        }
        
        return parent::beforeAction($action);
    }
}