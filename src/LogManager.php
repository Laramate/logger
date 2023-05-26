<?php

namespace Pretzels\Logger;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;
use Throwable;

class LogManager
{
    public static string $info = 'info';
    public static string $debug = 'debug';
    public static string $warning = 'warning';
    public static string $error = 'error';

    /**
     * The log channel.
     *
     * @var string
     */
    protected string $channel;

    /**
     * Log to console.
     *
     * @var bool
     */
    protected bool $on_console = true;

    /**
     * Log to log channel.
     *
     * @var bool
     */
    protected bool $on_log_channel = true;

    /**
     * Set the log channel.
     *
     * @param string|null $channel
     * @return self
     */
    public function channel(?string $channel = null): static
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Log on console only.
     *
     * @return $this
     */
    public function consoleOnly(): static
    {
        $this->on_log_channel = false;
        $this->on_console = true;

        return $this;
    }

    /**
     * Log on channel only.
     *
     * @return $this
     */
    public function channelOnly(): static
    {
        $this->on_log_channel = true;
        $this->on_console = false;

        return $this;
    }

    /**
     * Log a message.
     *
     * @param string $type
     * @param string $message
     * @param array|null $context
     * @param Throwable|null $error
     * @return self
     */
    protected function log(string $type, string $message, ?array $context = null, ?Throwable $error = null): static
    {
        $message = $error ? "{$message}. {$error->getMessage()}" : $message;

        if ($this->on_log_channel) {
            $this->logOnChannel($type, $message, $context);
        }

        if ($this->on_console) {
            $this->logOnConsole($type, $message, $context);
        }

        return $this;
    }

    /**
     * Log on channel.
     *
     * @param string $type
     * @param string $message
     * @param array|null $context
     * @return void
     */
    protected function logOnChannel(string $type, string $message, ?array $context = null): void
    {
        if (!empty($this->channel)) {
            Log::channel($this->channel)->$type($message, $context);
        } else {
            Log::$type($message, $context);
        }
    }

    /**
     * Log on console.
     *
     * @param string $type
     * @param string $message
     * @param array|null $context
     * @return void
     */
    protected function logOnConsole(string $type, string $message, ?array $context = null): void
    {
        if (!app()->runningInConsole()) {
            return;
        }

        $message = $this->styleConsoleOutput($type, $message);

        if ($context) {
            $context = json_encode($context);
            $message = "{$message} {$context}";
        }

        $out = new ConsoleOutput();
        $out->writeln($message);
    }


    /**
     * Style console output.
     *
     * @param string $type
     * @param string $message
     * @return string
     */
    protected function styleConsoleOutput(string $type, string $message): string
    {
        return match ($type) {
            static::$info => "<info>{$message}</info>",
            static::$warning => "<comment>{$message}</comment>",
            static::$error => "<error>{$message}</error>",
            default => $message,
        };
    }

    /**
     * Log an info message.
     *
     * @param string $message
     * @param array|null $context
     * @param Throwable|null $error
     * @return self
     */
    public function info(string $message, ?array $context = null, ?Throwable $error = null): static
    {
        return $this->log(static::$info, $message, $context, $error);
    }

    /**
     * Log a warning message.
     *
     * @param string $message
     * @param array|null $context
     * @param Throwable|null $error
     * @return self
     */
    public function warning(string $message, ?array $context = null, ?Throwable $error = null): static
    {
        return $this->log(static::$warning, $message, $context, $error);
    }

    /**
     * Log a warning message.
     *
     * @param string $message
     * @param array|null $context
     * @param Throwable|null $error
     * @return self
     */
    public function debug(string $message, ?array $context = null, ?Throwable $error = null): static
    {
        return $this->log(static::$warning, $message, $context, $error);
    }

    /**
     * Log an error message.
     *
     * @param string $message
     * @param array|null $context
     * @param Throwable|null $error
     * @return self
     */
    public function error(string $message, ?array $context = null, ?Throwable $error = null): static
    {
        return $this->log(static::$error, $message, $context, $error);
    }
}
