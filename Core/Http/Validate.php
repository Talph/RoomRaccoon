<?php

namespace Core\Http;
trait Validate
{
    public function validateArray($key, $formValue): void
    {
        if (!is_array($formValue)) {
            $message = ["$key value is not valid, array expected"];
            $this->rulesBagMessage[$key] = $message;
        }

        $this->addRulesMessages($key, $formValue, is_array($formValue), $message ?? []);

    }

    public function validateFloat($key, $formValue): void
    {
        $this->addFilterValidations($key, $formValue, 'FLOAT', FILTER_VALIDATE_FLOAT);
    }

    public function validateEmail($key, $formValue): void
    {
        $this->addFilterValidations($key, $formValue, 'EMAIL', FILTER_VALIDATE_EMAIL);
    }

    public function validateBool($key, $formValue): void
    {
        $this->addFilterValidations($key, $formValue, 'BOOL', FILTER_VALIDATE_BOOL);
    }

    public function validateInt($key, $formValue): void
    {
        $this->addFilterValidations($key, $formValue, 'INT', FILTER_VALIDATE_INT);
    }

    public function validateString($key, $formValue): void
    {
        if (!is_string($formValue)) {
            $message = ["$key value is not valid, string expected"];
            $this->rulesBagMessage[$key] = $message;
        }

        $this->addRulesMessages($key, $formValue, is_string($formValue), $message ?? []);

    }

    public function validateRequired($key, $formValue = ''): void
    {
        if (!$formValue) {
            $message = ["$key is required"];
            $this->rulesBagMessage[$key] = $message;
        }

        $this->addRulesMessages($key, $formValue, !$formValue, $message ?? []);
    }

    public function validatePasswordVerify($key, string $formValue = '', string $formValueVerify = ''): void
    {

        if ($formValue !== $formValueVerify) {
            $message = ["$key(s) do not match."];
            $this->rulesBagMessage[$key] = $message;
        }
        if (!$formValue) {
            $message = ["$key is required"];
            $this->rulesBagMessage[$key] = $message;
        }

        $this->addRulesMessages($key, $formValue, !$formValue, $message ?? []);
    }

    public function validationChecks(array $rulesArray, string $param, mixed $formValue): void
    {

        if (in_array('REQUIRED', $rulesArray)) {
            $this->validateRequired($param, $formValue);
        }

        if(!$this->rulesBagMessage){
            if (in_array('STRING', $rulesArray)) {
                $this->validateString($param, $formValue);
            }

            if (in_array('BOOL', $rulesArray)) {
                $this->validateBool($param, $formValue);
            }

            if (in_array('ARRAY', $rulesArray)) {
                $this->validateArray($param, $formValue);
            }

            if (in_array('INT', $rulesArray)) {
                $this->validateInt($param, $formValue);
            }

            if (in_array('EMAIL', $rulesArray)) {
                $this->validateEmail($param, $formValue);
            }

            if (in_array('FLOAT', $rulesArray)) {
                $this->validateFloat($param, $formValue);
            }

            if (in_array('PASSWORD_VERIFY', $rulesArray)) {
                $this->validatePasswordVerify($param, $formValue);
            }
        }


    }

    /**
     * @return array
     */
    public function validated(): array
    {
        foreach ($this->getChildRules() as $param => $value) {
            $rulesArray = explode(',', strtoupper(strtolower(trim($value))));
            foreach (self::getRequestParameters() as $key => $formValue) {
                if ($key === $param) {
                    $this->validationChecks($rulesArray, $key, $formValue);
                }
                if ($key === 'password_verify') {
                    $this->validatePasswordVerify($key, self::getRequestParameters()['password'] ?? '', self::getRequestParameters()['password_verify'] ?? '');
                }
            }

        }

        $rulesOmittedFromRequest = array_diff_key($this->getChildRules(), self::getRequestParameters());
        if ($rulesOmittedFromRequest) {
            foreach ($rulesOmittedFromRequest as $key => $ruleOmitted) {
                $this->validateRequired(strtolower($key));
            }
        }

        $this->triggerErrorMessages();

        return $this->validatedData;
    }

    private function addFilterValidations(string $key, mixed $formValue, string $type, $filter): void
    {
        if (!filter_var($formValue, $filter)) {
            $message = ["$key value is not valid, $type expected"];
            $this->rulesBagMessage[$key] = $message;
        }

        $this->addRulesMessages($key, $formValue, filter_var($formValue, $filter), $message ?? []);
    }


    private function addRulesMessages(string $key, mixed $formValue, bool $bool, array $errorMessage = []): void
    {

    }
}