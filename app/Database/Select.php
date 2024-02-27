<?php

namespace App\Database;

class Select
{
    private string $sql;
    private bool $haveMoreCondition = false;
    private array $binds = [];
    public function query(string $query): self
    {
        $this->sql = $query;
        return $this;
    }

    public function where(string $field, string $operator, mixed $value): self
    {
        $conditional = $this->haveMoreCondition ? " and" : " where";
        $this->sql .= "$conditional {$field} {$operator} :{$field}";
        $this->haveMoreCondition = true;
        $this->binds[$field] = $value;
        return $this;
    }

    public function orWhere(string $field, string $operator, mixed $value): self
    {
        $this->sql .= " or {$field} {$operator} :{$field}";
        $this->binds[$field] = $value;
        return $this;
    }

    public function orderBy(string $field, string $order = 'ASC'): self
    {
        $this->sql .= " order by {$field} {$order}";
        return $this;
    }

    public function get(): string
    {
        return $this->sql;
    }

    public function getBinds(): array
    {
        return $this->binds;
    }
}