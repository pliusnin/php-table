<?php

namespace PhpTable\DataTable;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class DataTableRenderer
{
    /**
     * @var DataTableConfig|null
     */
    private ?DataTableConfig $config = null;

    /**
     * @var Environment
     */
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return DataTableConfig|null
     */
    public function getConfig(): ?DataTableConfig
    {
        return $this->config;
    }

    /**
     * @param DataTableConfig $config
     * @return DataTableRenderer
     */
    public function setConfig(DataTableConfig $config): DataTableRenderer
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(): string
    {
        $fields = $this->config->getFields();
        uasort($fields, function (DataTableField $a, DataTableField $b) {
            return $a->getOrder() - $b->getOrder();
        });

        return $this->twig->render($this->config->getTemplate(), [
            'rows' => $this->config->getRows(),
            'fields' => $fields,
            'rowLink' => $this->config->getRowLink()
        ]);
    }

    /**
     * @return string
     * @throws DataTableException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function renderPagination(): string
    {
        if (!$paginationParams = $this->getConfig()->getPaginationParams()) {
            throw new DataTableException('Pagination params should be set before calling render function. Use `getConfig()->setPaginationParams($params)');
        }

        $paginationParams['totalPages'] = $paginationParams['totalPages'] ?: 1;
        $stepAround = floor($paginationParams['size']/2);
        $firstPage = 1;
        $lastPage = $paginationParams['totalPages'];
        $size = $paginationParams['size'] - 1;
        $paginationParams['currentPage'] = $paginationParams['currentPage'] > $lastPage ? $lastPage : $paginationParams['currentPage'];

        if ($paginationParams['totalPages'] > $paginationParams['size']) {
            if ($paginationParams['currentPage'] - $stepAround > 0) {
                $firstPage = $paginationParams['currentPage'] - $stepAround;
            }

            if ($firstPage + $size < $paginationParams['totalPages']) {
                $lastPage = $firstPage + $size;
            } else {
                $firstPage = $paginationParams['totalPages'] - $size;
            }
        }

        // TODO: make template string configurable
        return $this->twig->render('portal/components/tablePagination.html.twig', array_merge($paginationParams, [
            'firstPage' => $firstPage,
            'lastPage' => $lastPage
        ]));
    }
}
