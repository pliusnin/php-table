<?php

namespace PhpTable\DataTable;

use Closure;

class DataTableConfig
{
    /**
     * @var DataTableField[]
     */
    private array $fields = [];

    /**
     * @var array
     */
    private array $rows;

    /**
     * @var string
     */
    private string $template = 'portal/components/tableList.html.twig';

    /**
     * @var null|array
     */
    private ?array $rowLink = null;

    /**
     * @var null|array
     */
    private ?array $paginationParams = null;

    /**
     * @param array $rows
     * @param array $fields
     */
    public function __construct(array $rows, array $fields = [])
    {
        foreach ($fields as $key => $field) {
            $this->addField($key, $field['label'], $field['order'] ?? null, $field['format'] ?? null);
        }
        $this->rows = $rows;
    }

    /**
     * @return DataTableField[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param $key
     * @param $label
     * @param $order
     * @param Closure|null $format
     * @return DataTableConfig
     */
    public function addField($key, $label, $order = null, Closure $format = null): DataTableConfig
    {
        $order = $order ?? count($this->fields);
        $this->fields[$key] = new DataTableField($label, $order, $format);

        return $this;
    }

    /**
     * @return array
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * @param array $rows
     * @return DataTableConfig
     */
    public function setRows(array $rows): DataTableConfig
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     * @return DataTableConfig
     */
    public function setTemplate(string $template): DataTableConfig
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRowLink(): ?array
    {
        return $this->rowLink;
    }

    /**
     * @param string $path
     * @param array $paramsMapping key - this is path key, value - original data key
     * @return $this
     */
    public function setRowLink(string $path, array $paramsMapping): DataTableConfig
    {
        $this->rowLink = [
            'path' => $path,
            'params' => $paramsMapping
        ];

        return $this;
    }

    /**
     * @return array|null
     */
    public function getPaginationParams(): ?array
    {
        return $this->paginationParams;
    }

    /**
     * @param int $currentPage
     * @param int $totalPages
     * @param int $size
     * @return $this
     */
    public function setPaginationParams(int $currentPage, int $totalPages, int $size = 5): DataTableConfig
    {
        $this->paginationParams = [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'size' => $size
        ];

        return $this;
    }
}
