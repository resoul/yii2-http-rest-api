<?php
namespace Middleware\Framework\Rest;

use Yii;
use yii\base\ErrorException;
use yii\base\UserException;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Custom error handler for REST API
 */
class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * @inheritdoc
     */
    protected function convertExceptionToArray($exception)
    {
        if (!YII_DEBUG && !$exception instanceof UserException && !$exception instanceof HttpException) {
            $exception = new HttpException(500, 'Internal Server Error');
        }

        $array = [
            'success' => false,
            'error' => [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'type' => get_class($exception),
            ],
        ];

        if ($exception instanceof HttpException) {
            $array['error']['status'] = $exception->statusCode;
        }

        if (YII_DEBUG) {
            $array['error']['file'] = $exception->getFile();
            $array['error']['line'] = $exception->getLine();
            $array['error']['trace'] = explode("\n", $exception->getTraceAsString());
        }

        if (($prev = $exception->getPrevious()) !== null) {
            $array['error']['previous'] = $this->convertExceptionToArray($prev);
        }

        return $array;
    }
}