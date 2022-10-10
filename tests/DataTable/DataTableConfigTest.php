<?php

use PhpTable\DataTable\DataTableConfig;
use PHPUnit\Framework\TestCase;

class DataTableConfigTest extends TestCase
{
    /**
     * @var DataTableConfig
     */
    private $dataTableConfig;

    protected function setUp(): void
    {
        $this->dataTableConfig = new DataTableConfig([], []);
    }

    public function testPaginationParams()
    {
        $this->assertNull($this->dataTableConfig->getPaginationParams());
        $result = $this->dataTableConfig->setPaginationParams(1, 10);
        $this->assertInstanceOf(DataTableConfig::class, $result);
        $this->assertIsArray($this->dataTableConfig->getPaginationParams());
        $this->assertArrayHasKey('currentPage', $this->dataTableConfig->getPaginationParams());
        $this->assertArrayHasKey('totalPages', $this->dataTableConfig->getPaginationParams());
        $this->assertArrayHasKey('size', $this->dataTableConfig->getPaginationParams());
        $this->assertEquals(1, $this->dataTableConfig->getPaginationParams()['currentPage']);
        $this->assertEquals(10, $this->dataTableConfig->getPaginationParams()['totalPages']);
        $this->assertEquals(5, $this->dataTableConfig->getPaginationParams()['size']);
    }

    public function testGetRowLink()
    {
        $this->assertNull($this->dataTableConfig->getRowLink());
        $result = $this->dataTableConfig->setRowLink('any_symfony_route', []);
        $this->assertInstanceOf(DataTableConfig::class, $result);
        $this->assertIsArray($this->dataTableConfig->getRowLink());
        $this->assertArrayHasKey('path', $this->dataTableConfig->getRowLink());
        $this->assertArrayHasKey('params', $this->dataTableConfig->getRowLink());
        $this->assertEquals('any_symfony_route', $this->dataTableConfig->getRowLink()['path']);
        $this->assertEquals([], $this->dataTableConfig->getRowLink()['params']);
    }

    public function testGetFields()
    {
        $this->assertIsArray($this->dataTableConfig->getFields());
        $this->assertCount(0, $this->dataTableConfig->getFields());
        $result = $this->dataTableConfig->addField('row', 'Label');
        $this->assertInstanceOf(DataTableConfig::class, $result);
    }

    public function test__construct()
    {
        $dataTableConfig = new DataTableConfig(['row' => 'value'], ['row' => [
            'label' => 'Label',
            'order' => 0,
            'format' => null
        ]]);
        $this->assertInstanceOf(DataTableConfig::class, $dataTableConfig);
    }

    public function testGetRows()
    {
        $this->assertIsArray($this->dataTableConfig->getRows());
        $this->assertCount(0, $this->dataTableConfig->getRows());
        $this->dataTableConfig->setRows(['row' => 'value']);
        $this->assertCount(1, $this->dataTableConfig->getRows());
    }

    public function testGetTemplate()
    {
        $this->assertIsString($this->dataTableConfig->getTemplate());
        $result = $this->dataTableConfig->setTemplate('template');
        $this->assertInstanceOf(DataTableConfig::class, $result);
        $this->assertEquals('template', $this->dataTableConfig->getTemplate());
    }
}
