<?php

declare(strict_types=1);

namespace Exceptions;

class ViewNotFoundException extends \Exception
{
    protected $message = '404 not found';

    protected $code = 404;

}