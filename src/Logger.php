<?php

namespace Pretzels\Logger;

use Illuminate\Support\Facades\Facade;
use Throwable;

/**
 * @method static info(string $message, ?Throwable $error = null)
 * @method static warning(string $message, ?Throwable $error = null)
 * @method static error(string $message, ?Throwable $error = null)
 * @method static channel(string $string)
 */
class Logger extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return LogManager::class;
    }
}
