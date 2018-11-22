<?php

namespace App\Storage\Query;

/**
 * Class InsertQueryBuilder
 * @package App\Storage\Query
 */
class InsertQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var Query
     */
    private $query;
    /** @var array */
    private $bindParams;

    /**
     * InsertQueryBuilder constructor.
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
        $insert = $this->getInsert();
        $insertedKeys = $this->getInsertedKeys();
        $insertedUpdatedValues = $this->getInsertedValues();

        return $insert.$insertedKeys.$insertedUpdatedValues;
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
    private function getInsert(): string
    {
        return 'INSERT INTO ' . $this->query->getTable();
    }

    /**
     * @return string
     */
    private function getInsertedKeys(): string
    {
        return ' ('.implode(',', array_keys($this->query->getInsert())).')';
    }

    /**
     * @return string
     */
    private function getInsertedValues(): string
    {
        $insertedValues = [];
        $updatedValues = [];
        foreach ($this->query->getInsert() as $key => $value) {
            $safeKey = str_replace('.', '_', $key);
            $insertedValues[] = ':'.$safeKey;
            $updatedValues[] = $key.'=:'.$safeKey;
            $this->bindParams[$safeKey] = $value;
        }

        $insertedString = ' VALUES ('.implode(',', $insertedValues).')';
        $updatedString = ' ON DUPLICATE KEY UPDATE '.implode(',', $updatedValues);

        return $insertedString.$updatedString;
    }
}
