<?php

declare(strict_types=1);

namespace Core\Http;

use Core\App;
use Core\Container;
use Core\Exceptions\ViewNotFoundException;
use Core\Middleware\AuthMiddleware;
use Core\Redirect;
use Exception;
use ReflectionMethod;

class Router
{
    use Validate;

    private const METHOD_POST = 'POST', METHOD_GET = 'GET', METHOD_DELETE = 'DELETE', METHOD_PUT = 'PUT';
    private array $rulesBagMessage = [], $handlers = [];
    private ?object $notFoundHandler, $requestObject;

    public function __construct()
    {
        (new App(new Container(), $this, ['url' => $_SERVER['REQUEST_URI'], ['method' => $_SERVER['REQUEST_METHOD']]]))->boot();
    }

    public function get(string $path, $handler, $middleware = 'web'): void
    {
        $this->addHandler(self::METHOD_GET, $path, $handler, $middleware);
    }

    public function post(string $path, $handler, $middleware = 'web'): void
    {
        $this->addHandler(self::METHOD_POST, $path, $handler, $middleware);
    }

    public function addHandler(string $method, string $path, $handler, $middleware): void
    {
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'controller' => $handler,
            'middleware' => $middleware
        ];
    }

    /**
     * @throws ViewNotFoundException
     * @throws Exception
     */
    public function run(): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];

        $callback = $this->simpleRouteHandler($requestPath, $method);
        if (!$callback) {
            $callback = $this->routeWithParameterHandler($requestPath, $method);
        }

        $args = [];
        if (is_array($callback)) {
            $className = array_shift($callback);
            $handler = new $className;
            $method = array_shift($callback);
            $callback = [$handler, $method];
            $args = $this->getMethodArguments($handler, $method);
            if (is_object($args)) {
                $args = $args->request;
            }
        }

        if (!$callback) {
            if (!empty($this->notFoundHandler)) {
                $callback = $this->notFoundHandler;
            }
            throw new ViewNotFoundException($requestPath . ' could not be found');
        }

        call_user_func_array($callback, [
            self::toRequestObject(array_merge($args))
        ]);

    }

    /**
     * @param $handler
     * @param $method
     * @return array|Redirect|mixed|object|void|null
     */
    public function getMethodArguments($handler, $method)
    {
        try {
            if (method_exists($handler, $method)) {
                $methodArgs = new ReflectionMethod($handler, $method);
                if (count($methodArgs->getParameters()) > 0) {
                    foreach ($methodArgs->getParameters() as $arg) {
                        if (!is_null($arg->getType())) {
                            $object = $arg->getType()->getName();
                            if (!array_key_exists($object, array_flip(['int', 'bool', 'boolean', 'integer', 'float', 'string', 'null', 'array']))) {
                                $this->requestObject = new $object;
                                return $this->requestObject;
                            } else {
                                $method = 'validate' . ucfirst($object);
                                $pass = !$this->$method($object, $_REQUEST['id']);
                                if ($pass) {
                                    return $_REQUEST;
                                }
                            }
                        }
                    }
                } else {
                    return $_REQUEST;
                }
            } else {
                return $_REQUEST;
            }
        } catch (\Exception $e) {
            return Redirect::route('/error', ['error_messages' => $e->getMessage()]);
        }
    }

    /**
     * @param string $requestPath
     * @param string $method
     * @return mixed|null
     */
    public function simpleRouteHandler(string $requestPath, string $method): mixed
    {
        foreach ($this->handlers as $handler) {
            if ($handler['path'] === $requestPath && $method === $handler['method']) {
                $callback = $handler['controller'];
                if ($handler['middleware'] !== 'web') {
                    $checkAuth = new AuthMiddleware();
                    $checkAuth->run();
                }
                break;
            }
        }

        return $callback ?? null;
    }

    /**
     * @param array $properties
     * @return array|object[]
     */
    private function toRequestObject(array $properties): mixed
    {
        $value = null;
        if (count($properties) > 0) {
            foreach ($properties as $key => $value) {
                if (!empty($this->requestObject)) {
                    $this->requestObject->$key = $value;
                }
                if (empty($this->requestObject)) {
                    return $value;
                }
            }
        }

        return !$value ? $_REQUEST : $this->requestObject;
    }

    /**
     * @param string $requestPath
     * @param string $method
     * @return mixed|null
     */
    private function routeWithParameterHandler(string $requestPath, string $method): mixed
    {
        $parts = [];
        $partsRegex = '`(.+?){(.+?)}`';
        $routeRegexes = [];

        foreach ($this->handlers as $handler) {
            preg_match($partsRegex, $handler['path'], $parts);
            if (count(array_filter($parts)) > 0) {
                $routeRegexes[] = [
                    'path' => $parts[1],
                    'varName' => $parts[2],
                    'routeRegex' => "`($parts[1])(.+)`"
                ];

                foreach ($routeRegexes as $routeRegex) {
                    if (preg_match($routeRegex['routeRegex'], $requestPath, $urlMatch)) {
                        $routeRegex['varValue'] = $urlMatch['2'];
                        $urlMatch = $routeRegex;
                    }
                }

                if (count(array_filter($urlMatch)) !== 0 && str_contains($requestPath, $urlMatch['path'])) {
                    if ($method === $handler['method']) {
                        $_REQUEST[$urlMatch['varName']] = $urlMatch['varValue'];
                        $callback = $handler['controller'];

                        if ($handler['middleware'] !== 'web') {
                            $checkAuth = new AuthMiddleware();
                            $checkAuth->run();
                        }
                    }
                }
            }
        }

        return $callback ?? null;
    }

}