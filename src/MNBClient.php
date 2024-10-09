<?php

namespace VrgDev\MNBClient;

use VrgDev\MNBClient\Exception\MNBClientException;
use VrgDev\MNBClient\MNBClientInterface;
use VrgDev\MNBClient\XmlParserInterface;

class MNBClient implements MNBClientInterface
{
    private \SoapClient $client;
    private XmlParserInterface $xmlParser;

    public function __construct(string $wsdl, ?\SoapClient $client = null)
    {
        $this->client = $client ?? new \SoapClient($wsdl);

        $this->xmlParser = new XmlParser();
    }

    public function getExchangeRates(): string
    {
        return $this->client->GetCurrentExchangeRates()->GetCurrentExchangeRatesResult;
    }

    public function getExchangeRate(string $currency): float
    {
        $exchangeRates = $this->getExchangeRates();

        $parsedExchangeRates = $this->xmlParser->parse($exchangeRates);

        $xpath = $parsedExchangeRates->xpath('/MNBCurrentExchangeRates/Day/Rate[@curr="' . $currency . '"]');

        if (!isset($xpath[0])) {
            throw new MNBClientException('Unable to find exchange rate!');
        }

        $exchangeRateUnit = (int) $xpath[0]->attributes()->unit;
        $exchangeRateValue = (float) str_replace(',', '.', $xpath[0][0]);

        return $exchangeRateValue / $exchangeRateUnit;
    }
}
