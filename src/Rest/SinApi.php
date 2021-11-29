<?php
 
namespace Hillus\SinTicketingClient\Rest;

class SinApi extends BaseSinApi
{
    

    public function getUsoIntegracao(int $projeto,int $periodo)
    {
        $url = $this->base_url.'/api/usointegracao/'.$projeto.'/'.$periodo;

        if(!$this->_accessToken || $this->tokenIsExpired())
        $this->login();
        
        $headers = [
            "Accept" => "application/json, text/plain, */*",
            "Accept-Language"=> "pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3",
            "Accept-Encoding"=> "gzip, deflate, br",
            "Authorization"=> "Bearer ".$this->_accessToken,
        ];

        $response = $this->get($url,$headers);

        return $response;
    }

    public function getUsuarios()
    {
        $url = $this->base_url.'/api/usuario';

        if(!$this->_accessToken || $this->tokenIsExpired())
        $this->login();
        
        $headers = [
            "Accept" => "application/json, text/plain, */*",
            "Accept-Language"=> "pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3",
            "Accept-Encoding"=> "gzip, deflate, br",
            "Authorization"=> "Bearer ".$this->_accessToken,
        ];

        $response = $this->get($url,$headers);

        return $response;
    }

    public function storeUsuario($data)
    {
        
        if(!$this->_accessToken || $this->tokenIsExpired())
        $this->login();

        $url = $this->base_url."/api/usuario";
        $headers = [
            "Accept" => "application/json",
            "Accept-Language"=> "pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3",
            "Accept-Encoding"=> "gzip, deflate, br",
            "Authorization"=> "Bearer ".$this->_accessToken,
        ];

        $response = $this->post($url, $data,$headers);
        
        return $response;
    }

    public function deleteUsuarios(int $projeto,int $periodo)
    {
        if(!$this->_accessToken || $this->tokenIsExpired())
        $this->login();

        $url = $this->base_url."/api/usuario/projeto/".$projeto."/periodo/".$periodo;
        
        $headers = [
            "Accept" => "application/json",
            "Accept-Language"=> "pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3",
            "Accept-Encoding"=> "gzip, deflate, br",
            "Authorization"=> "Bearer ".$this->_accessToken,
        ];

        $response = $this->delete($url,$headers);
        
        return $response;        
    }

    
}
    