<?php

namespace Tests\Unit;

use App\ApiClients\Supermetrics\SupermetricsApiClient;
use Exception;
use PHPUnit\Framework\TestCase;

class SupermetricsApiClientTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testTokenSaved(): void
    {
        $client = $this->getMockBuilder(SupermetricsApiClient::class)
            ->onlyMethods(["baseRequest"])
            ->getMock();

        $token = "123";

        $client->expects($this->once())
            ->method("baseRequest")
            ->willReturn(["data" => ["sl_token" => $token]]);

        $client->authRequest();

        $this->assertEquals($token, $client->getToken());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testErrorIfNoToken(): void
    {
        $client = $this->getMockBuilder(SupermetricsApiClient::class)
            ->onlyMethods(["baseRequest"])
            ->getMock();

        $client->expects($this->once())
            ->method("baseRequest")
            ->willReturn(["no" => "token"]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Can't login to Supermetrics API");

        $client->authRequest();
    }
}
