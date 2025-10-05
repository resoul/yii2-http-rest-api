<?php
namespace Middleware\Framework\Rest;

use Yii;
use yii\filters\Cors;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\rest\Controller as BaseController;

/**
 * Base REST Controller with common behaviors
 */
class Controller extends BaseController
{
    /**
     * @var bool Enable authentication
     */
    public bool $enableAuth = false;

    /**
     * @var array Actions that don't require authentication
     */
    public array $optionalAuth = [];

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => $this->getAllowedOrigins(),
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => ['X-Pagination-Total-Count', 'X-Pagination-Page-Count'],
            ],
        ];

        // Content Negotiator
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        // Authentication
        if ($this->enableAuth) {
            $behaviors['authenticator'] = [
                'class' => HttpBearerAuth::class,
                'optional' => $this->optionalAuth,
            ];
        }

        // Verb Filter
        $behaviors['verbFilter'] = [
            'class' => VerbFilter::class,
            'actions' => $this->verbs(),
        ];

        return $behaviors;
    }

    /**
     * Get allowed origins for CORS
     *
     * @return array
     */
    protected function getAllowedOrigins(): array
    {
        if (YII_ENV_PROD) {
            return Yii::$app->params['allowedOrigins'] ?? ['*'];
        }
        return ['*'];
    }

    /**
     * Define allowed HTTP verbs for actions
     *
     * @return array
     */
    protected function verbs(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        if (is_array($result) && !isset($result['meta'])) {
            $result = [
                'data' => $result,
                'meta' => [
                    'timestamp' => time(),
                    'version' => Yii::$app->params['apiVersion'] ?? '1.0',
                ],
            ];
        }

        return $result;
    }
}
