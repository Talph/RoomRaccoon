<?php

namespace Core;

class Request
{
    public array $request;

    public function __construct()
    {
        $this->request = $_REQUEST;
    }

    /**
     * @param string $property
     * @param $value
     * @return void
     */
    public function __set(string $property, $value): void
    {
        $this->request[$property] = $value;
    }

    /**
     * @param string $property
     * @return mixed|null
     */
    public function __get(string $property)
    {
        return array_key_exists($property, $this->request)
            ? $this->request[$property]
            : null;
    }

    /**
     * @param mixed $keyValue
     * @return mixed|string|null
     */
    public function get(mixed $keyValue)
    {
        foreach ($this->request as $key => $value) {
            if (isset($key) && strtolower($key) === strtolower($keyValue)) {
                if (is_string($value)) {
                    $value = trim($value);
                }
                return $value;
            }
        }

        return null;
    }

    /**
     * @param mixed $keyValue
     * @param $default
     * @return mixed|string|null
     */
    public function input(mixed $keyValue, $default = null)
    {
        foreach ($this->request as $key => $value) {
            if (isset($key) && strtolower($key) === strtolower($keyValue)) {
                if (is_string($value)) {
                    $value = trim($value);
                }
                return trim($value);
            }
        }

        return $default;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->request;
    }

    public function except(array $properties = []): array
    {
        foreach ($this->request as $key => $value) {
            if (isset($key) && array_key_exists($key, array_flip($properties))) {
                $this->request = array_diff_key($this->request, array_flip($properties));
            }
        }

        return $this->request;
    }
}