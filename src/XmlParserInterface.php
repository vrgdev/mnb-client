<?php

namespace VrgDev\MNBClient;

interface XmlParserInterface
{
    public function parse(string $xmlString): \SimpleXMLElement;
}
