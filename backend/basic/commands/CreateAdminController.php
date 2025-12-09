<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Usuario;
use Yii;

class CreateAdminController extends Controller
{
    public function actionIndex($username = 'admin', $password = 'admin123', $name = 'Administrador')
    {
        $usuario = new Usuario();
        $usuario->username = $username;
        $usuario->name = $name;
        $usuario->password = Yii::$app->security->generatePasswordHash($password);
        $usuario->authkey = Yii::$app->security->generateRandomString();
        
        if ($usuario->save()) {
            echo "Usuario '$username' creado exitosamente.\n";
            echo "Username: $username\n";
            echo "Password: $password\n";
        } else {
            echo "Error al crear el usuario:\n";
            print_r($usuario->errors);
        }
    }
}
