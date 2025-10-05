<?php
namespace Middleware\Framework\Validators;

use Ramsey\Uuid\Uuid;
use yii\validators\Validator;

/**
 * UUID Validator
 */
class UuidValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;

        if (!Uuid::isValid($value)) {
            $this->addError($model, $attribute, '{attribute} is not a valid UUID.');
        }
    }
}