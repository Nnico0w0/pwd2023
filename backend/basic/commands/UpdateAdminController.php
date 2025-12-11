<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Usuario;

class UpdateAdminController extends Controller
{
    public function actionIndex()
    {
        $user = Usuario::findOne(['username' => 'admin']);
        if ($user) {
            $user->admin = true;
            if ($user->save()) {
                echo "Usuario admin actualizado correctamente. Ahora tiene privilegios de administrador.\n";
            } else {
                echo "Error al actualizar: " . print_r($user->errors, true);
            }
        } else {
            echo "Usuario admin no encontrado\n";
        }
    }
}