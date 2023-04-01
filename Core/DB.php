<?php

declare(strict_types = 1);

namespace Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

/**
 * @mixin Connection
 */
class DB
{
    private Connection $connection;

    /**
     * @throws Exception
     */
    public function __construct(array $config)
    {
        $this->connection = DriverManager::getConnection($config);
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->connection, $name], $arguments);
    }
}