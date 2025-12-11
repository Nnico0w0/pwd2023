<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Usuario models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Usuario();

        if ($model->load(Yii::$app->request->post())){
            if ($model ->validate())
            {
                $model->username=$_POST['Usuario']['username'];
                $model->name=$_POST['Usuario']['name'];
                $model->admin=isset($_POST['Usuario']['admin']) ? (bool)$_POST['Usuario']['admin'] : false;
                $model->password=password_hash($_POST['Usuario']['password'], PASSWORD_BCRYPT);
                $model->authkey=md5(random_bytes(5));
                $model->accesstoken=password_hash(random_bytes(5), PASSWORD_DEFAULT);
                if ($model->save())
                {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else
                {
                    $model->getErrors();
                }
            }
            else{
                $model->getErrors();
            }
        }
   
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            // Si se proporciona una nueva contraseña, hashearla
            if (!empty($model->password)) {
                $model->password = password_hash($model->password, PASSWORD_BCRYPT);
            } else {
                // Si no se proporciona contraseña, mantener la actual
                $model->password = $this->findModel($id)->password;
            }
            
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        // Limpiar contraseña para el formulario
        $model->password = '';
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
