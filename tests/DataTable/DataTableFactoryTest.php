<?php

use PhpTable\DataTable\DataTableFactory;
use PhpTable\DataTable\DataTableRenderer;
use PHPUnit\Framework\TestCase;
use Twig\Environment;

class DataTableFactoryTest extends TestCase
{
    public function testCreate()
    {
        $twigTwig = $this->createMock(Environment::class);
        $instance = new DataTableFactory($twigTwig);
        $renderer = $instance->create([], []);
        $this->assertInstanceOf(DataTableRenderer::class, $renderer);
    }
}
