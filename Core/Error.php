<?php

namespace Core;

use App\Config;
use ErrorException;
use Exception;
use Json\JsonResponse;

/**
 * Error and exception handler
 *
 * PHP version 8.2
 */
class Error
{

    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     *
     * @param int $level Error level
     * @param string $message Error message
     * @param string $file Filename the error was raised in
     * @param int $line Line number in the file
     *
     * @return void
     * @throws ErrorException
     */
    public static function errorHandler(int $level, string $message, string $file, int $line): void
    {
        if (error_reporting() !== 0) {  // to keep the @ operator working
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception handler.
     *
     * @param $exception // The exception
     *
     * @throws Exception
     */
    public static function exceptionHandler($exception)
    {
        // Default 500 (general error)
        $code = $exception->getCode();
        if (!in_array($code, [400, 401, 402, 403, 404, 419])) {
            $code = 500;
        }

        http_response_code($code);

        if (isset($_SERVER['HTTP_ACCEPT']) && $_SERVER['HTTP_ACCEPT'] === 'application/json') {
            $message = json_decode($exception->getMessage());
            if (is_object($message)) {
                $message = json_decode($exception->getMessage());
            } else {
                $message = [' Uncaught exception: ' . get_class($exception) . ' ' . $exception->getMessage()];
            }

            return JsonResponse::response()->json(["message" => $message]);

        } else if (Config::SHOW_ERRORS) {
            echo "<h1>Fatal error</h1>";
            echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
            echo "<p>Message: '" . $exception->getMessage() . "'</p>";
            echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' online " . $exception->getLine() . "</p>";
        } else {
            $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.log';
            ini_set('error_log', $log);

            $message = "Uncaught exception: '" . get_class($exception) . "'";
            $message .= " with message '" . $exception->getMessage() . "'";
            $message .= "\nStack trace: " . $exception->getTraceAsString();
            $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

            error_log($message);

        }
    }
}
