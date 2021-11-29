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

    protected $willExpiresAt = null;

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
        $response = null;
        try 
        {
            $debug = $this->config->get('sinticketing.debug', false);

            $options = [
                'body'=>json_encode($data),
                'headers'=>$header,
                'debug' => $debug
            ];

            $response = $this->client->post($url,$options);
        } 
        catch (\GuzzleHttp\Exception\ClientException  $e) 
        {
            $response = $e->getResponse();
        }
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

    }

    protected function delete($url,$header=[])  : ResponseInterface
    {
        $headerMain = [
            'Content-Type'=>'application/json',
            'accept'=>'application/json',
        ];

        $header = array_merge($headerMain,$header);
        $response = null;
        try 
        {
            $debug = $this->config->get('sinticketing.debug', false);

            $options = [
                'headers'=>$header,
                'debug' => $debug
            ];

            $response = $this->client->delete($url,$options);
        } 
        catch (\GuzzleHttp\Exception\ClientException  $e) 
        {
            $response = $e->getResponse();
        }
        return new Response($response);

    }

    public function login($user=null,$pass=null)
    {
        $user = $user ?? $this->userApi;
        $pass = $pass ?? $this->passwordApi;
        
        $url = $this->base_url.'/api/login';

        $response = $this->post($url, [
                            "email" => $user,
                            "password" => $pass,
                        ]);
        

        $r = $response->json();

        if($response->status() >= 400){
            throw new \Exception("Erro ao realizar login");
        }

    
        $this->_accessToken = $r->accessToken;
        $this->_expireInSeconds = $r->expireInSeconds;
        $this->_userId = $r->userId;

        // guarda quando será necessário fazer novo login
        $this->willExpiresAt = date("Y-m-d H:i:s", time() + $this->_expireInSeconds);

        $debug = $this->config->get('sinticketing.debug', false);

        if($debug){
            dump($this->willExpiresAt);
        }

        return $response;
    }

    public function tokenIsExpired()
    {
        return ($this->willExpiresAt < date('Y-m-d H:i:s')) ? true : false;
    }

    
}
    