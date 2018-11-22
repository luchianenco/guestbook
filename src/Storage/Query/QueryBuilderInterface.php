<?php

namespace App\Storage\Query;

/**
 * Interface QueryBuilderInterface
 * @package App\Storage\Query
 */
interface QueryBuilderInterface
{
    /**
     * @return array
     */
    public function getBindParams(): array;

    /**
     * @return string
     */
    public function build(): string;
}
