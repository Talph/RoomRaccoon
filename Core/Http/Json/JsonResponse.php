<?php

declare(strict_types=1);

namespace Core\Http\Json;

use Exception;

class JsonResponse
{
    public static array $currentValue = [];
    private static ?JsonResponse $_instance = null;

    public static function response(): ?JsonResponse
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * @throws Exception
     */
    public function json(mixed $array, int $flags = 0, $depth = 512): static
    {
        self::$currentValue = $array;
        if (!is_array(self::$currentValue)) {
            throw new Exception('Value is not an array');
        }

        if (!headers_sent()) {
            header('Content-Type: application/json');
            header('Accept: application/json');
        }

        echo json_encode(self::$currentValue, $flags, $depth);

        return $this;
    }
}