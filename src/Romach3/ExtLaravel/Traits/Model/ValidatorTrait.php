<?php
namespace Romach3\ExtLaravel\Traits\Model;

trait ValidatorTrait
{
    public $rules = [];
    public $messages = [];
    public $validator = null;
    public $rulesCreating = [];
    public $rulesUpdating = [];
    public $rulesForm = [];
    public $rulesSetId = [];

    public static function boot()
    {
        parent::boot();

        $validatorAction = function ($type, $model) {
            $rules = [];
            if ($type === 'creating') {
                $rules = array_merge($model->rules, $model->rulesCreating);
            } elseif ($type === 'updating') {
                $rules = array_merge($model->rules, $model->rulesUpdating);
            }
            foreach ($model->rulesSetId as $name) {
                if (isset($rules[$name])) {
                    $rules[$name] = str_replace('{id}', $model->id, $rules[$name]);
                }
            }
            if (count($rules) === 0) {
                return true;
            }
            $validator = \Validator::make($model->getAttributes(), $rules, $model->messages);
            if ($validator->fails()) {
                $model->validator = $validator;
                return false;
            }
            $model->validator = null;
            return true;
        };

        self::creating(function ($model) use ($validatorAction) {
            return $validatorAction('creating', $model);
        });

        self::updating(function ($model) use ($validatorAction) {
            return $validatorAction('updating', $model);
        });
    }
}
