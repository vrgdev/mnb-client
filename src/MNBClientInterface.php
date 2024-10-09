<?php

namespace VrgDev\MNBClient;

interface MNBClientInterface
{
    public function __construct(string $wsdl, \SoapClient $client);

    public function getExchangeRates(): string;

    public function getExchangeRate(string $currency): float;
}
