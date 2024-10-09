<?php

namespace VrgDev\MNBClient;

use VrgDev\MNBClient\Exception\XmlParserException;
use VrgDev\MNBClient\XmlParserInterface;

class XmlParser implements XmlParserInterface
{
    public function parse(string $xmlString): \SimpleXMLElement
    {
        $xml = simplexml_load_string($xmlString);

        if ($xml === false) {
            throw new XmlParserException('Unable to parse XML!');
        }

        return $xml;
    }
}
