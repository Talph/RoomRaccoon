<?php

declare(strict_types=1);

namespace Core;

use Core\Http\Router;
use Doctrine\DBAL\Exception;
use Dotenv\Dotenv;

class App
{
    private static DB $db;
    private Config $config;

    public function __construct(
        protected Container $container,
        protected ?Router   $router = null,
        protected array     $request = [],
    )
    {
    }

    public static function db(): DB
    {
        return static::$db;
    }

    /**
     * @throws Exception
     */
    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->config = new Config($_ENV);

        static::$db = new DB($this->config->db ?? []);

        return $this;
    }

}