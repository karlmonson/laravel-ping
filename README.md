# Ping for Laravel

This Laravel package is simple and unopinionated. It simply returns the HTTP Status Code for a provided URL.

## Installation

Install via Composer:
```bash
composer require karlmonson/laravel-ping
```
You'll need to register the ServiceProvider and Facade:
```php
// config/app.php

'providers' => [
    // ...
    Karlmonson\Ping\PingServiceProvider::class,
];

'aliases' => [
    // ...
    'Ping' => Karlmonson\Ping\Facades\Ping::class,
];
```

## Usage

```php
<?php

namespace App\Http\Controllers;

use Ping;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    /**
     * Show the current health of a given URL.
     *
     * @param  string  $url
     * @return string
     */
    public function healthCheck($url)
    {
        $health = Ping::check($url);

        if($health == 200) {
            return 'Alive!';
        } else {
            return 'Dead :(';
        }
    }
}
```

## Credits

- [Karl Monson](https://github.com/karlmonson) - Author
- [Eric Blount](https://github.com/ericmakesstuff) - Inspiration ([ericmakesstuff/laravel-server-monitor](https://github.com/ericmakesstuff/laravel-server-monitor))

## License

The MIT License (MIT). Please see [License File](https://github.com/karlmonson/laravel-ping/blob/master/LICENSE.md) for more information.