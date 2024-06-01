<?php

namespace Core\Database;

class QueryBuilder
{
    private array $select = [];
    private array $wheres = [];
    private array $params = [];

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

    public function get(): array|bool
    {
        $sql = 'SELECT ' . implode(',', $this->select)
            . ' FROM ' . $this->table;

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ';
            foreach ($this->wheres as $index => $where) {
                if ($index > 0) {
                    $sql .= $where['type'] . ' ';
                }
                $sql .= $where['expression'];
            }
        }

        $statement = $this->database->pdo->prepare($sql);

        foreach ($this->params as $key => $value) {
            $statement->bindValue($key, $value);
        }

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
