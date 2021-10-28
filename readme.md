## Sin-Ticketing Client for Laravel

### Laravel wrapper for [Dompdf HTML to PDF Converter](https://github.com/dompdf/dompdf)

Require this package in your composer.json and update composer. This will download the package and the dompdf + fontlib libraries also.

    composer require hillus/sin-ticketing-client

## Installation

### Laravel 5.x:

After updating composer, add the ServiceProvider to the providers array in config/app.php

    Hillus\SinTicketingClient\ServiceProvider::class,

You can optionally use the facade for shorter code. Add this to your facades:

    'SinTicketingClient' => Hillus\SinTicketingClient\Facade::class,

  
## Using

You can create a new DOMPDF instance and load a HTML string, file or view name. You can save it to a file, or stream (show in browser) or download.

```php
    $pdf = App::make('sinticketing');
    $res = $pdf->storeUsuario([...]);
    return $res;
```
    

Or use the facade:

```php
    $res = SinTicketingClient::login();
    return $res->json()->accessToken;
```


If you need the output as a string, you can get the rendered PDF with the output() function, so you can save/output it yourself.

Use `php artisan vendor:publish` to create a config file located at `config/sinticketing.php` which will allow you to define local configurations to change some settings (default paper etc).
You can also use your ConfigProvider to set certain keys.
    
### License

This DOMPDF Wrapper for Laravel is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
