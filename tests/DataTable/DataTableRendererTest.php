<?php

use PhpTable\DataTable\DataTableConfig;
use PhpTable\DataTable\DataTableException;
use PhpTable\DataTable\DataTableField;
use PhpTable\DataTable\DataTableRenderer;
use PHPUnit\Framework\TestCase;
use Twig\Environment;

class DataTableRendererTest extends TestCase
{
    private DataTableRenderer $dataTableRenderer;

    protected function setUp(): void
    {
        $twigMock = $this->createMock(Environment::class);
        $twigMock
            ->method('render')
            ->willReturn('');
        $this->dataTableRenderer = new DataTableRenderer($twigMock);
    }

    public function testGetConfig()
    {
        $this->assertNull($this->dataTableRenderer->getConfig());
        $dataTableConfigMock = $this->createMock(DataTableConfig::class);
        $this->dataTableRenderer->setConfig($dataTableConfigMock);
        $this->assertInstanceOf(DataTableConfig::class, $this->dataTableRenderer->getConfig());
    }

    public function testRenderPagination()
    {
        $dataTableConfigMock = $this->createMock(DataTableConfig::class);
        $dataTableConfigMock
            ->method('getPaginationParams')
            ->willReturn([
                'currentPage' => 1,
                'totalPages' => 10,
                'size' => 5
            ]);
        $twigMock = $this->createMock(Environment::class);
        $twigMock
            ->expects($this->once())
            ->method('render')
            ->with(
                'portal/components/tablePagination.html.twig',
                [
                    'currentPage' => 1,
                    'totalPages' => 10,
                    'size' => 5,
                    'firstPage' => 1,
                    'lastPage' => 5
                ]
            );
        $dataTableRenderer = new DataTableRenderer($twigMock);
        $dataTableRenderer->setConfig($dataTableConfigMock);
        $dataTableRenderer->renderPagination();
    }

    public function testRenderPaginationOtherCase()
    {
        $dataTableConfigMock = $this->createMock(DataTableConfig::class);
        $dataTableConfigMock
            ->method('getPaginationParams')
            ->willReturn([
                'currentPage' => 10,
                'totalPages' => 10,
                'size' => 5
            ]);
        $twigMock = $this->createMock(Environment::class);
        $twigMock
            ->expects($this->once())
            ->method('render')
            ->with(
                'portal/components/tablePagination.html.twig',
                [
                    'currentPage' => 10,
                    'totalPages' => 10,
                    'size' => 5,
                    'firstPage' => 6,
                    'lastPage' => 10
                ]
            );
        $dataTableRenderer = new DataTableRenderer($twigMock);
        $dataTableRenderer->setConfig($dataTableConfigMock);
        $dataTableRenderer->renderPagination();
    }

    public function testRenderPaginationException()
    {
        $dataTableConfigMock = $this->createMock(DataTableConfig::class);
        $dataTableConfigMock
            ->method('getPaginationParams')
            ->willReturn(null);
        $dataTableRenderer = new DataTableRenderer($this->createMock(Environment::class));
        $dataTableRenderer->setConfig($dataTableConfigMock);
        $this->expectException(DataTableException::class);
        $dataTableRenderer->renderPagination();
    }

    public function testRender()
    {
        $field1Mock = $this->createMock(DataTableField::class);
        $field1Mock->method('getOrder')->willReturn(2);
        $field2Mock = $this->createMock(DataTableField::class);
        $field2Mock->method('getOrder')->willReturn(1);

        $dataTableConfigMock = $this->createMock(DataTableConfig::class);
        $dataTableConfigMock
            ->method('getFields')
            ->willReturn([
                $field1Mock,
                $field2Mock
            ]);
        $dataTableConfigMock
            ->method('getRows')
            ->willReturn([]);
        $dataTableConfigMock
            ->method('getRowLink')
            ->willReturn([]);
        $dataTableConfigMock
            ->method('getTemplate')
            ->willReturn('');

        $this->dataTableRenderer->setConfig($dataTableConfigMock);
        $this->assertEquals('', $this->dataTableRenderer->render());
    }
}
