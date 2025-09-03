<?php

namespace Laramate\Logger;

use Illuminate\Support\Facades\Facade;
use Throwable;

/**
 * @method static info(string $message, ?array $context = null, ?Throwable $error = null)
 * @method static debug(string $message, ?array $context = null, ?Throwable $error = null)
 * @method static warning(string $message, ?array $context = null, ?Throwable $error = null)
 * @method static error(string $message, ?array $context = null, ?Throwable $error = null)
 * @method static channel(?string $channel = null)
 * @method static consoleOnly()
 * @method static channelOnly()
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
