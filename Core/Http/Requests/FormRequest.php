<?php

namespace Core\Http\Requests;

use Core\{Redirect, Request};
use Core\Http\Validate;
use Exception;
use ValidationErrorMessage;

abstract class FormRequest extends Request implements ValidationErrorMessage
{
    use Validate;

    private const FORMAT_EMAIL = 'EMAIL', TYPE_INT = 'INT', TYPE_STRING = 'STRING', TYPE_FLOAT = 'FLOAT', TYPE_BOOL = 'BOOL',
        TYPE_ARRAY = 'ARRAY', TYPE_DOUBLE = 'DOUBLE', FORMAT_REQUIRED = 'REQUIRED', FORMAT_MAX = 'MAX';
    private string|array $childRules;
    private array $rulesBag = [], $rulesBagMessage = [], $validatedData = [];
    private bool $hasErrors = false;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->setChildRules($this->setRules());
        if (!empty($this->getChildRules())) {
            $this->validated();
        }

    }

    public function triggerErrorMessages()
    {
        if ($this->rulesBagMessage) {
            Redirect::route('/error', ['error_messages' => $this->rulesBagMessage]);
            exit();
        }
        return true;
    }

    /**
     * @return array
     */
    private function getRequestParameters(): array
    {
        return $this->request;
    }

    /**
     * @param $rules
     * @return void
     */
    private function setChildRules($rules): void
    {
        $this->childRules = $rules;
    }

    /**
     * @return array|string
     */
    private function getChildRules(): array|string
    {
        return $this->childRules;
    }

    /**
     * @throws Exception
     */
    private function setRules(): array|string
    {
        $formRequestService = new FormRequestServiceProvider();
        if (method_exists($this, 'rules')) {
            if (method_exists($this, 'authorize')) {
                if (!$formRequestService->authorized(get_class($this))) {

                    throw new Exception("authorize() method returned false on class: " . get_class($this));
                }

                return $formRequestService->getFormRequestRules(get_class($this));
            }
        }

        throw new Exception("Could not find either rules() and authorize() methods on class:" . get_class($this));
    }
}