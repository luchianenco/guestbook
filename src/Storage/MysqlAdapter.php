<?php

namespace App\Storage;

use PDO;
use Generator;
use App\Storage\Query\Query;
use App\Storage\Query\InsertQueryBuilder;
use App\Storage\Query\SelectQueryBuilder;

/**
 * Class MysqlAdapter
 * @package App\Storage
 */
class MysqlAdapter implements AdapterInterface
{
    /** @var \PDO */
    private $connection;

    /**
     * MysqlAdapter constructor.
     * @param \PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param Query $query
     * @return bool
     */
    public function upsert(Query $query): bool
    {
        $qb = new InsertQueryBuilder($query);
        $st = $this->connection->prepare($qb->build());

        return $st->execute($qb->getBindParams());
    }


    /**
     * @param Query $query
     * @return Generator
     */
    public function select(Query $query): Generator
    {
        $qb = new SelectQueryBuilder($query);
        $st = $this->connection->prepare($qb->build());
        $st->execute($qb->getBindParams());

        while ($row = $st->fetch(\PDO::FETCH_ASSOC)) {
            yield $row;
        }
    }
}
