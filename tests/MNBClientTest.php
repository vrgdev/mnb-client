<?php

use PHPUnit\Framework\TestCase;
use VrgDev\MNBClient\Exception\MNBClientException;
use VrgDev\MNBClient\MNBClient;

class MNBClientTest extends TestCase
{
    private MNBClient $mnbClient;

    protected function setUp(): void
    {
        $soapClientMock = $this->getMockBuilder(\SoapClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $soapClientMock->method('__call')
            ->willReturn(
                new class {
                    public string $GetCurrentExchangeRatesResult = '<MNBCurrentExchangeRates><Day><Rate unit="2" curr="TEST">200</Rate></Day></MNBCurrentExchangeRates>';
                }
            );

        $this->mnbClient = new MNBClient('', $soapClientMock);
    }

    public function testGetExchangeRates(): void
    {
        $this->assertIsString($this->mnbClient->getExchangeRates());
    }

    public function testGetExchangeRate(): void
    {
        $this->assertSame(100.00, $this->mnbClient->getExchangeRate('TEST'));
    }

    public function testGetExchangeRateFailed(): void
    {
        $this->expectException(MNBClientException::class);

        $this->mnbClient->getExchangeRate('TESTX');
    }
}
