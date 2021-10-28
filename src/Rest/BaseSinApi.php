<?php
 
namespace Hillus\SinTicketingClient\Rest;

use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Filesystem\Filesystem;
use GuzzleHttp\Client;

abstract class BaseSinApi
{
    protected $base_url;
    protected $passwordApi = "";
    protected $userApi = "";

    protected $_accessToken;
    protected $_encryptedAccessToken;

    protected $client;

    /** @var \Illuminate\Contracts\Config\Repository  */
    protected $config;

    /** @var \Illuminate\Filesystem\Filesystem  */
    protected $files;

    /**
     * @param Dompdf $dompdf
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(ConfigRepository $config, Filesystem $files)
    {
        $this->config = $config;
        $this->files = $files;

        $this->base_url = $this->config->get('sinticketing.api_base_url', false);
        $this->passwordApi = $this->config->get('sinticketing.api_sin_password', false);
        $this->userApi = $this->config->get('sinticketing.api_sin_user', false);
        $this->client = new Client();
    }

    protected function post($url,$data,$header=[]) : ResponseInterface
    {
        $headerMain = [
            'Content-Type'=>'application/json',
            'accept'=>'application/json',
        ];

        $header = array_merge($headerMain,$header);

        $response = $this->client->post($url,['body'=>json_encode($data),'headers'=>$header]);
        // $body = $response->getBody();
        // $conteudo = '';
        // while (!$body->eof()) {
        //     $conteudo .= $body->read(1024);
        // }

        // if($response->getStatusCode() >= 400)
        // throw new \Exception($conteudo);

        // return json_decode($conteudo);
        return new Response($response);
    }

    protected function get($url,$header=[])  : ResponseInterface
    {
        $headerMain = [
            'Content-Type'=>'application/json',
            'accept'=>'application/json',
        ];

        $header = array_merge($headerMain,$header);

        $response = $this->client->get($url,['headers'=>$header]);
        return new Response($response);
        // $body = $response->getBody();
        // $conteudo = '';
        // while (!$body->eof()) {
        //     $conteudo .= $body->read(1024);
        // }

        // if($response->getStatusCode() >= 400)
        // throw new \Exception($conteudo);

        // return json_decode($conteudo);
    }

    public function login()
    {
        $url = $this->base_url.'/api/login';
        $response = $this->post($url, [
                            "email" => $this->userApi,
                            "password" => $this->passwordApi,
                        ]);
        

        $r = $response->json();

        if($response->status() >= 400){
            throw new \Exception("Erro ao realizar login");
        }

    
        $this->_accessToken = $r->accessToken;
        $this->_expireInSeconds = $r->expireInSeconds;
        $this->_userId = $r->userId;

        return $response;
    }

    

    
}
    