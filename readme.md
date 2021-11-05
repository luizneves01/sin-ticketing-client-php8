## Sin-Ticketing Client for Laravel

### Laravel SDK client for [Sin-Ticketing](https://sinticketing.sinsolution.com.br)

Require this package in your composer.json and update composer. This will download the package and the dompdf + fontlib libraries also.

    composer require hillus/sin-ticketing-client

## Installation

### Laravel 5.x:

Depois de atualizar o composer, altere o arquivo config/app.php e na lista de providers adicione o arquivo ServiceProvider 

    Hillus\SinTicketingClient\ServiceProvider::class,

Você também pode adicionar a fachada, colocando no array aliases dentro de config/app.php

    'SinTicketingClient' => Hillus\SinTicketingClient\Facade::class,

  
## Using

You can create a new DOMPDF instance and load a HTML string, file or view name. You can save it to a file, or stream (show in browser) or download.

```php
    $client = App::make('sinticketing');
    $res = $client->storeUsuario([...]);
    return $res;
```
    

Or use the facade:

```php
    $res = SinTicketingClient::login();
    return $res->json()->accessToken;
```

Use `php artisan vendor:publish` to create a config file located at `config/sinticketing.php` which will allow you to define local configurations to change some settings (default paper etc).
You can also use your ConfigProvider to set certain keys.
    
### License

This Sin Ticketing Client for Laravel is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
