<?php

namespace Core\Database;

class QueryBuilder
{
    private array $select = [];
    private array $wheres = [];
    private array $params = [];
    private ?string $groupBy = null;
    private ?string $orderByField = null;
    private ?string $orderByDirection = null;
    private ?int $limit = null;

    public function __construct(
        private readonly Database $database,
        private readonly string   $table = ''
    ) {}

    public function select(string ...$fields): static
    {
        $this->select = $fields;

        return $this;
    }

    public function where(string $expression): static
    {
        $this->wheres[] = ['type' => 'AND', 'expression' => $expression];

        return $this;
    }

    public function setParameter(string $key, mixed $value): static
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function groupBy(string $field): static
    {
        $this->groupBy = $field;

        return $this;
    }

    public function orderBy(string $field, string $direction = 'ASC'): static
    {
        $this->orderByField = $field;
        $this->orderByDirection = $direction;

        return $this;
    }

    public function limit(int $value): static
    {
        $this->limit = $value;

        return $this;
    }

    public function get(): array|bool
    {
        $sql = 'SELECT ' . implode(',', $this->select)
            . ' FROM ' . $this->table;

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ';
            foreach ($this->wheres as $index => $where) {
                if ($index > 0) {
                    $sql .= ' ' . $where['type'] . ' ';
                }
                $sql .= $where['expression'];
            }
        }

        if (!empty($this->groupBy)) {
            $sql .= ' GROUP BY ' . $this->groupBy;
        }

        if (!empty($this->orderByField)) {
            $sql .= ' ORDER BY ' . $this->orderByField;
            if (!empty($this->orderByDirection)) {
                $sql .= ' ' . $this->orderByDirection;
            }
        }

        if (!empty($this->limit)) {
            $sql .= ' LIMIT ' . $this->limit;
        }

        $statement = $this->database->pdo->prepare($sql);

        foreach ($this->params as $key => $value) {
            $statement->bindValue($key, $value);
        }

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}