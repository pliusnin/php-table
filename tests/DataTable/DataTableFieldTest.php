<?php

use PhpTable\DataTable\DataTableField;
use PHPUnit\Framework\TestCase;

class DataTableFieldTest extends TestCase
{
    const LABEL = 'Field Label';

    protected function getInstance(): DataTableField
    {
        return new DataTableField(self::LABEL, 0, null);
    }

    public function testGetLabel()
    {
        $instance = $this->getInstance();
        $this->assertSame(self::LABEL, $instance->getLabel());
    }

    public function testGetOrder()
    {
        $instance = $this->getInstance();
        $this->assertSame(0, $instance->getOrder());
    }

    public function testGetFormat()
    {
        $instance = $this->getInstance();
        $this->assertInstanceOf('Closure', $instance->getFormat());
        $this->assertSame('value', $instance->getFormat()(['key' => 'value'], 'key'));
        $this->assertSame('Undefined key', $instance->getFormat()(['key' => 'value'], 'unknownKey'));
    }

    public function testGetFormatCustom()
    {
        $instance = new DataTableField(self::LABEL, 0, function () {
            return 'Custom response';
        });
        $this->assertSame('Custom response', $instance->getFormat()(['key' => 'value'], 'key'));
    }
}
