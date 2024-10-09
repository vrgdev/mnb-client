<?php

use PHPUnit\Framework\TestCase;
use VrgDev\MNBClient\Exception\XmlParserException;
use VrgDev\MNBClient\XmlParser;

class XmlParserTest extends TestCase
{
    private XmlParser $xmlParser;

    protected function setUp(): void
    {
        $this->xmlParser = new XmlParser();
    }

    public function testParse(): void
    {
        $this->assertInstanceOf(\SimpleXMLElement::class, $this->xmlParser->parse('<Root><Node>TEST</Node></Root>'));
    }

    public function testParseFailed(): void
    {
        $this->expectException(XmlParserException::class);

        $this->xmlParser->parse('');
    }
}
