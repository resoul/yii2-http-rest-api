<?php
namespace Middleware\Framework\Helpers;

use Yii;
use yii\web\Response;

/**
 * Helper for standardized API responses
 */
class ResponseHelper
{
    /**
     * Success response
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return array
     */
    public static function success($data = [], ?string $message = null, int $code = 200): array
    {
        Yii::$app->response->statusCode = $code;

        return [
            'success' => true,
            'data' => $data,
            'message' => $message,
            'meta' => [
                'timestamp' => time(),
            ],
        ];
    }

    /**
     * Error response
     *
     * @param string $message
     * @param int $code
     * @param array $errors
     * @return array
     */
    public static function error(string $message, int $code = 400, array $errors = []): array
    {
        Yii::$app->response->statusCode = $code;

        $response = [
            'success' => false,
            'error' => [
                'message' => $message,
                'code' => $code,
            ],
        ];

        if (!empty($errors)) {
            $response['error']['details'] = $errors;
        }

        return $response;
    }

    /**
     * Paginated response
     *
     * @param array $items
     * @param int $total
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public static function paginated(array $items, int $total, int $page = 1, int $perPage = 20): array
    {
        return [
            'success' => true,
            'data' => $items,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'per_page' => $perPage,
                'total_pages' => (int) ceil($total / $perPage),
            ],
            'meta' => [
                'timestamp' => time(),
            ],
        ];
    }
}