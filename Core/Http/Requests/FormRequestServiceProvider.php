<?php

namespace Core\Http\Requests;

class FormRequestServiceProvider
{
    public array $rules = [];
    public bool $authorized = false;
    public function getFormRequestRules($class): array
    {
        if(class_exists($class)){
          $this->rules = $class::rules() ?? [];
        }

        return $this->rules;
    }

    public function authorized($class): bool
    {
        if(class_exists($class)){
            $this->authorized = $class::authorize();
        }

        return $this->authorized;
    }
}