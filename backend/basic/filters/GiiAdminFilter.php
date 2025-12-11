<?php

namespace app\filters;

use yii\base\BootstrapInterface;
use yii\web\ForbiddenHttpException;
use Yii;

class GiiAdminFilter implements BootstrapInterface
{
    public function bootstrap($app)
    {
        // Solo aplicar en entorno de desarrollo y cuando Gii está habilitado
        if (YII_ENV_DEV && isset($app->modules['gii'])) {
            $app->on(\yii\web\Application::EVENT_BEFORE_ACTION, function ($event) {
                $action = $event->action;
                
                // Verificar si la acción pertenece al módulo Gii
                if ($action->controller->module && $action->controller->module->id === 'gii') {
                    if (Yii::$app->user->isGuest) {
                        Yii::$app->user->loginRequired();
                        $event->handled = true;
                        return;
                    }
                    
                    $user = Yii::$app->user->identity;
                    if (!$user || !$user->isAdmin()) {
                        Yii::$app->user->logout();
                        Yii::$app->session->setFlash('error', 'Solo los administradores pueden acceder a Gii.');
                        Yii::$app->response->redirect(['/site/login'])->send();
                        $event->handled = true;
                    }
                }
            });
        }
    }
}