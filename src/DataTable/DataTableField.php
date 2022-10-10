<?php

namespace PhpTable\DataTable;

use Closure;

class DataTableField
{
    /**
     * @var string
     */
    private string $label;

    /**
     * @var Closure
     */
    private Closure $format;

    /**
     * @var int
     */
    private int $order;

    /**
     * @param string $label
     * @param int $order
     * @param Closure|null $format
     */
    public function __construct(string $label, int $order, Closure $format = null)
    {
        $this->label = $label;
        $this->order = $order;
        $this->format = $format ?? function ($row, $key) {
            return array_key_exists($key, $row) ? $row[$key] : 'Undefined key';
        };
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return Closure
     */
    public function getFormat(): Closure
    {
        return $this->format;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }
}
