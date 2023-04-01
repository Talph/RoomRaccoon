<?php

namespace Core\Contracts;

use InvalidArgumentException;

interface ValidationErrorMessage
{
    /**
     * @throws InvalidArgumentException
     */
    public function triggerErrorMessages();
}