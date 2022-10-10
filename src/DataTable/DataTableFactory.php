<?php

namespace PhpTable\DataTable;

use Twig\Environment;

class DataTableFactory
{
    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->twig = $environment;
    }

    /**
     * @param array $dataArray
     * @param array $headersArray
     * @return DataTableRenderer
     */
    public function create(array $dataArray, array $headersArray): DataTableRenderer
    {
        $config = new DataTableConfig($dataArray, $headersArray);

        return (new DataTableRenderer($this->twig))->setConfig($config);
    }
}
