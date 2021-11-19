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


### Lumen:

Depois de atualizar o composer adicione a linha baixo para registrar o proviver em bootstrap/app.php

$app->register(\Hillus\SinTicketingClient\ServiceProvider::class);

Para alterar a configuração, copie o arquivo config para a sua pasta config e habilite no arquivo bootstrap/app.php:

$app->configure('sinTicketing');

Using
## Using

Você pode receber uma instancia do cliente a partir do exemplo abaixo
```php
    $client = App::make('sinticketing');
    $res = $client->storeUsuario([...]);
    return $res;
```
    

Ou você pode usar a fachada:

```php
    $res = SinTicketingClient::login();
    return $res->json()->accessToken;
```

Para os métodos de  storeUsuario, getUsuarios você recebe uma instancia de  Hillus\SinTicketingClient\Rest\Response, uma classe que tem os métodos auxiliares status, body, json, heder, headers e erro. Essa classe recebe no seu construtor uma instancia da classe Reponse do Guzzle6.0 por uma questão de compatiblidade com os projetos antigos.

```php

    $res = SinTicketingClient::storeUsuario([
        "codigo" => 1,
        "nome" => 'Nome',
        "email" => 'usuario@example.com',
        "status" => 'A',
        "permissao" => 'Administrador',
        "grupoEconomico" => null,
        "criadoEm" => Carbon::now()->format('Y-m-d H:i:s'),
        "atualizadoEm" => Carbon::now()->format('Y-m-d H:i:s')      
    ]);

    if($res->status() == 201){
        $this->info($res->json()->id);
    }else if($res->status() >= 400){
        $this->error("erro ao processar usuario");
        dump($res->json());
    }
```


Use `php artisan vendor:publish` to create a config file located at `config/sinticketing.php` which will allow you to define local configurations to change some settings (default paper etc).
You can also use your ConfigProvider to set certain keys.
    
### License

This Sin Ticketing Client for Laravel is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
