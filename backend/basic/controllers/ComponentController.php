<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\Cors;
use yii\web\UnauthorizedHttpException;
use app\components\JwtHelper;

class ComponentController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Remove auth filter if it exists to avoid conflicts, we use manual check
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['GET'],
                'view' => ['GET'],
            ],
        ];

        return $behaviors;
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($action->id === 'options') {
                return true;
            }
            
            $this->requireJwt();
            return true;
        }
        return false;
    }

    /**
     * Validates Authorization: Bearer <token> header using JwtHelper.
     */
    protected function requireJwt()
    {
        $auth = Yii::$app->request->headers->get('Authorization');
        if (!$auth || stripos($auth, 'Bearer ') !== 0) {
            throw new UnauthorizedHttpException('Missing or invalid Authorization header');
        }
        $token = trim(substr($auth, 7));
        $decoded = JwtHelper::validateToken($token);
        
        if (!$decoded) {
            throw new UnauthorizedHttpException('Invalid or expired token');
        }
        
        // Optionally set user identity
        // Yii::$app->user->login(Usuario::findIdentity($decoded->userId));
    }

    public function actionIndex()
    {
        $componentsPath = Yii::getAlias('@app') . '/../../frontend/src/components';
        $files = [];
        
        if (is_dir($componentsPath)) {
            $dir = new \DirectoryIterator($componentsPath);
            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot() && $fileinfo->isFile() && $fileinfo->getExtension() === 'vue') {
                    $files[] = [
                        'name' => $fileinfo->getFilename(),
                    ];
                }
            }
        }
        
        return $files;
    }

    public function actionView($name)
    {
        $componentsPath = Yii::getAlias('@app') . '/../../frontend/src/components';
        $filePath = $componentsPath . '/' . $name;
        
        // Basic security check to prevent directory traversal
        if (file_exists($filePath) && strpos(realpath($filePath), realpath($componentsPath)) === 0) {
            return [
                'name' => $name,
                'content' => file_get_contents($filePath),
            ];
        }
        
        throw new \yii\web\NotFoundHttpException("Component not found: $name");
    }
}
