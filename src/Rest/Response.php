<?php
 
namespace Hillus\SinTicketingClient\Rest;

use Psr\Http\Message\ResponseInterface as ResponseInterfaceGuzzle;

class Response implements ResponseInterface
{

    private $response;

    public function __construct(ResponseInterfaceGuzzle $response)
    {
        $this->response = $response;
    }

    public function status() : int
    {
        return $this->response->getStatusCode();
    }

    public function body(): string
    {
        static $conteudo;

        if(empty($conteudo))
        {
            $body = $this->response->getBody();
            $conteudo = '';
            while (!$body->eof()) {
                $conteudo .= $body->read(1024);
            }
        }
        
        return $conteudo;
    }

    public function json()
    {
        $return = json_decode($this->body());
        return $return;
    }

    public function header($header): string
    {
        $return = "";
        if($this->response->hasHeader($header)){
            $returns  = $this->response->getHeader($header);
            if(is_array($returns)){
                $return = $returns[0];
            }else{
                $return = $returns;
            }
        }
        return $return;
    }

    public function headers() : array {
        $return  = [];
        // Represent the headers as a string
        foreach ($this->response->getHeaders->getHeaders() as $name => $values) {
            // echo $name . ": " . implode(", ", $values);
            $return[$name] = $values;
        }
        return $return;
    }

    public function error(): string {
        return $this->body();
    }

}