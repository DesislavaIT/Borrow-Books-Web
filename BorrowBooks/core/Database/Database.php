<?php

namespace Core\Database;

class Database
{
    public ?\PDO $pdo;

    /**
     * @param array{ host: string, user: string, pass: string, name: string } $config
     *
     * @throws \Exception
     */
    public function __construct(array $config)
    {
        $host = $config['host'] ?? 'localhost';
        $user = $config['user'] ?? 'root';
        $pass = $config['pass'] ?? '';
        $name = $config['name'] ?? '';

        try {
            $this->pdo = new \PDO("mysql:host=$host;dbname=$name", $user, $pass);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $exception) {
            throw new \Exception('Database connection failed: ' . $exception->getMessage());
        }
    }

    public function query(string $table): QueryBuilder
    {
        return new QueryBuilder($this, $table);
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
}
