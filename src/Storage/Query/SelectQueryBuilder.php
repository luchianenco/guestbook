<?php

namespace App\Storage\Query;

/**
 * Class QueryBuilder
 * @package App\Storage\Query
 */
class SelectQueryBuilder implements QueryBuilderInterface
{
    /** @var Query */
    private $query;
    /** @var array */
    private $bindParams;

    /**
     * QueryBuilder constructor.
     * @param Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
        $this->bindParams = [];
    }

    /**
     * @return string
     */
    public function build(): string
    {
        $select = $this->getSelect();
        $from = $this->getFrom();
        $leftJoin = $this->getLeftJoin();
        $where = $this->getWhere();
        $orderBy = $this->getOrderBy();

        return $select.$from.$leftJoin.$where.$orderBy;
    }

    /**
     * @return array
     */
    public function getBindParams(): array
    {
        return $this->bindParams;
    }

    /**
     * @return string
     */
    private function getSelect(): string
    {
        $selectClause = '*';

        if ($filtered = array_filter($this->query->getSelect())) {
            $selectClause = implode(',', $filtered);
        }

        return 'SELECT ' . $selectClause;
    }

    /**
     * @return string
     */
    private function getFrom(): string
    {
        return ' FROM '. $this->query->getTable();
    }

    /**
     * @return string
     */
    private function getLeftJoin(): string
    {
        $leftJoin = '';
        if ($this->query->getJoinTable()) {
            $leftJoin = sprintf(
                ' LEFT JOIN %s ON %s.id=%s.%s',
                $this->query->getJoinTable(),
                $this->query->getJoinTable(),
                $this->query->getTable(),
                $this->query->getJoinField()
            );
        }

        return $leftJoin;
    }

    /**
     * @return string
     */
    private function getWhere(): string
    {
        $whereParams = [];
        $values = $this->query->getWhere();
        foreach ($values as $key => $value) {
            $safeKey = str_replace('.', '_', $key);
            $whereParams[] = $key.'=:'.$safeKey;
            $this->bindParams[$safeKey] = $value;
        }

        $whereClause = implode(' AND ', $whereParams);

        if ($whereClause) {
            $whereClause = ' WHERE '.$whereClause;
        }

        return $whereClause;
    }

    /**
     * @return string
     */
    private function getOrderBy(): string
    {
        if ([] === $this->query->getOrderBy()) {
            return '';
        }

        $orderBy = [];
        foreach ($this->query->getOrderBy() as $key => $value) {
            $orderBy[] = $key.' '.$value;
        }

        return ' ORDER BY '.implode(',', $orderBy);
    }
}
