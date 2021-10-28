<?php

namespace Hillus\SinTicketingClient\Tests;

use Hillus\SinTicketingClient\Facade;
use Hillus\SinTicketingClient\Rest\ResponseInterface;


class PdfTest extends TestCase
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
    }

    public function testSendUsuario(): void
    {
        $res = \SinTicketingClient::login();
        $this->assertEquals(200, $res->status());

        $data = [        
            'codigo' => '01',
            'nome' => 'Teste Usuário Teste',
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
        $this->assertEquals(201, $response->status());
    }

    public function testView(): void
    {
        $response = \SinTicketingClient::getUsuarios();

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertNotEmpty($response->body());
        $this->assertEquals('application/json', $response->header('Content-Type'));
        $this->assertEquals(200, $response->status());
    }

}