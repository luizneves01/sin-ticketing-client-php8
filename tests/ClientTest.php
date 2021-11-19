<?php

namespace Hillus\SinTicketingClient\Tests;

use Hillus\SinTicketingClient\Facade;
use Hillus\SinTicketingClient\Rest\ResponseInterface;


class ClientTest extends TestCase
{
    public function testAlias(): void
    {
        $res = \SinTicketingClient::login();
        $response = $res->json();
        $this->assertTrue(($res instanceof ResponseInterface));
        $this->assertTrue(isset($response->projetoId));
        $this->assertNotEmpty($response->accessToken);
    }

    public function testFacade(): void
    {
        $res = Facade::login();
        $response = $res->json();
        
        /** @var Response $response */
        $this->assertTrue(isset($response->projetoId));
        $this->assertNotEmpty($response->accessToken);
        $this->assertEquals(Facade::tokenIsExpired(),false);
    }

    public function testSendUsuario(): void
    {
        $res = \SinTicketingClient::login();
        $this->assertEquals(200, $res->status());

        for($i=1;$i<=4;$i++)
        {
            $data = [        
                'codigo' => str_pad($i,4,'0',STR_PAD_LEFT),
                'nome' => 'Teste Usuário Teste '.$i,
                'email' => 'usuario'.$i.'@test.com',
                'status' => 'A',
                'permissao' => 'Admin',
                'grupoEconomico' => '',
                'criadoEm' => '2010-01-01 10:11:02',
                'atualizadoEm' => '2010-01-01 10:11:02',
            ];

            $response = \SinTicketingClient::storeUsuario($data);
            // dump($response->body());
            /** @var Response $response */
            $this->assertInstanceOf(ResponseInterface::class, $response);
            $this->assertNotEmpty($response->body());
            $this->assertEquals('application/json', $response->header('Content-Type'));
            $this->assertEquals(201, $response->status());
            
        }
    }

    public function testStoreUsuarioErrorNome(): void
    {
        $res = \SinTicketingClient::login();
        $this->assertEquals(200, $res->status());

        $data = [        
            'codigo' => '01',
            // 'nome' => 'Teste Usuário Teste',
            'email' => 'teste@bergamo.com',
            'status' => 'A',
            'permissao' => 'Admin',
            'grupoEconomico' => '',
            'criadoEm' => '2010-01-01 10:11:02',
            'atualizadoEm' => '2010-01-01 10:11:02',
        ];

        $response = \SinTicketingClient::storeUsuario($data);
        /** @var Response $response */
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertNotEmpty($response->body());
        $this->assertEquals('application/json', $response->header('Content-Type'));
        $this->assertEquals(422, $response->status());
        $this->assertNotEmpty($response->error()->errors->nome);
        
    }

    public function testStoreUsuarioErrorEmail(): void
    {
        $res = \SinTicketingClient::login();
        $this->assertEquals(200, $res->status());

        $data = [        
            'codigo' => '01',
            'nome' => 'Teste Usuário Teste',
            'email' => 'teste.',
            'status' => 'A',
            'permissao' => 'Admin',
            'grupoEconomico' => '',
            'criadoEm' => '2010-01-01 10:11:02',
            'atualizadoEm' => '2010-01-01 10:11:02',
        ];

        $response = \SinTicketingClient::storeUsuario($data);
        // dump(__METHOD__);
        // dump($response->body());
        /** @var Response $response */
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertNotEmpty($response->body());
        $this->assertEquals('application/json', $response->header('Content-Type'));
        $this->assertEquals(422, $response->status());
        $this->assertNotEmpty($response->error()->errors->email);
        
    }


}