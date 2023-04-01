<?php


interface ValidationErrorMessage
{
    /**
     * @throws InvalidArgumentException
     */
    public function triggerErrorMessages();
}