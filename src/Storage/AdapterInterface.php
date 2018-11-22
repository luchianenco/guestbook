<?php

namespace App\Storage;

use Generator;
use App\Storage\Query\Query;

/**
 * Class AdapterInterface
 * @package App\Storage
 */
interface AdapterInterface
{
    /**
     * @param Query $query
     * @return \Generator
     */
    public function select(Query $query): Generator;

    /**
     * @param Query $query
     * @return bool
     */
    public function upsert(Query $query): bool;
}
