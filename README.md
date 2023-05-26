# Automated logging to the console or log-channels.

### Send Log messages to your configured channels or to the console, depending on the environment.

---

Imagine, you run the same code, as a job and as a command. 
In both scenarios, you would like to have proper output, either through the configured log-channels or the console.

Logger will handle it for you:

```php
use Pretzels\Logger\Logger;

Logger::info('Salz!');
```

- If the app is on console, Logger will log your message and output it to the console.
- If the app is on the log channel, it will only log your message to the configured channels.

## Contributing

Feel free to contribute to this package.

## Security

If you've found a bug regarding security please mail [mail@pretzels.dev](mail@pretzels.dev) instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.