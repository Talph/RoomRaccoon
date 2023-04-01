<?php

declare(strict_types=1);

namespace Core\Http;

use Core\Http\Json\JsonResponse;
use \Exception;

abstract class Controller extends JsonResponse
{
    /**
     * @throws Exception
     */
    public function __call(string $method, array $args)
    {
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    protected function before()
    {
    }

    protected function after()
    {
    }
}