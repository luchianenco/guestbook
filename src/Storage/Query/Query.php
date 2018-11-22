<?php

namespace App\Storage\Query;

/**
 * Class QueryBuilder
 * @package App\Storage\Query
 */
class Query
{
    /** @var string  */
    protected $table;
    /** @var array */
    protected $select;
    /** @var array */
    protected $insert;
    /** @var array */
    protected $where;
    /** @var string */
    protected $joinTable;
    /** @var string */
    protected $joinField;
    /** @var array */
    protected $orderBy;

    /**
     * Query constructor.
     */
    public function __construct()
    {
        $this->select = [];
        $this->insert = [];
        $this->where = [];
        $this->orderBy = [];
        $this->joinTable = '';
        $this->joinField = '';
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     * @return Query
     */
    public function setTable(string $table): Query
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @return array
     */
    public function getSelect(): array
    {
        return $this->select;
    }

    /**
     * @param array $select
     * @return Query
     */
    public function setSelect(array $select = []): Query
    {
        $this->select = $select;

        return $this;
    }

    /**
     * @return array
     */
    public function getInsert(): array
    {
        return $this->insert;
    }

    /**
     * @param array $insert
     * @return Query
     */
    public function setInsert(array $insert): Query
    {
        $this->insert = $insert;

        return $this;
    }

    /**
     * @return array
     */
    public function getWhere(): array
    {
        return $this->where;
    }


    /**
     * @param array $where
     * @return Query
     */
    public function setWhere(array $where = []): Query
    {
        $this->where = $where;

        return $this;
    }

    /**
     * @return string
     */
    public function getJoinField(): string
    {
        return $this->joinField;
    }

    /**
     * @param string $joinField
     * @return Query
     */
    public function setJoinField(string $joinField): Query
    {
        $this->joinField = $joinField;

        return $this;
    }

    /**
     * @return string
     */
    public function getJoinTable(): string
    {
        return $this->joinTable;
    }

    /**
     * @param string $joinTable
     * @return Query
     */
    public function setJoinTable(string $joinTable): Query
    {
        $this->joinTable = $joinTable;

        return $this;
    }

    /**
     * @return array
     */
    public function getOrderBy(): array
    {
        return $this->orderBy;
    }

    /**
     * @param array $orderBy
     * @return Query
     */
    public function setOrderBy(array $orderBy): Query
    {
        $this->orderBy = $orderBy;

        return $this;
    }
}
