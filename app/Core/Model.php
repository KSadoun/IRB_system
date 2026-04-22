<?php

namespace App\Core;

use PDO;
use PDOStatement;

class Model
{
    protected static PDO $db;

    protected string $table = '';
    protected string $primaryKey = 'id';
    protected array $fillable = [];

    public function __construct()
    {
        if (!isset(self::$db)) {
            $config = require __DIR__ . '/../../config/database.php';

            self::$db = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
                $config['user'],
                $config['password']
            );

            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
    }

    public static function db(): PDO
    {
        if (!isset(self::$db)) {
            new static();
        }

        return self::$db;
    }

    public function getAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $this->assertTableDefined();

        $sql = "SELECT * FROM {$this->table}";
        if ($orderBy !== '') {
            $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
            $sql .= " ORDER BY {$orderBy} {$direction}";
        }

        $stmt = self::db()->query($sql);
        return $stmt->fetchAll();
    }

    public function getById(int|string $id): ?array
    {
        $this->assertTableDefined();

        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        $stmt = self::db()->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int|string
    {
        $this->assertTableDefined();
        $data = $this->filterFillable($data);

        if (empty($data)) {
            throw new \InvalidArgumentException('No valid data provided for insert.');
        }

        $columns = array_keys($data);
        $placeholders = array_map(fn ($column) => ':' . $column, $columns);

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $stmt = self::db()->prepare($sql);
        $stmt->execute($data);

        return self::db()->lastInsertId();
    }

    public function update(int|string $id, array $data): bool
    {
        $this->assertTableDefined();
        $data = $this->filterFillable($data);

        if (empty($data)) {
            throw new \InvalidArgumentException('No valid data provided for update.');
        }

        $setClause = implode(', ', array_map(fn ($column) => "{$column} = :{$column}", array_keys($data)));
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = :_id";

        $stmt = self::db()->prepare($sql);
        $data['_id'] = $id;

        return $stmt->execute($data);
    }

    public function delete(int|string $id): bool
    {
        $this->assertTableDefined();

        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = self::db()->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    public function firstWhere(string $column, mixed $value): ?array
    {
        $this->assertTableDefined();

        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1";
        $stmt = self::db()->prepare($sql);
        $stmt->execute(['value' => $value]);

        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function where(string $column, mixed $value): array
    {
        $this->assertTableDefined();

        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :value";
        $stmt = self::db()->prepare($sql);
        $stmt->execute(['value' => $value]);

        return $stmt->fetchAll();
    }

    protected function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = self::db()->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    protected function filterFillable(array $data): array
    {
        if (empty($this->fillable)) {
            return $data;
        }

        return array_filter(
            $data,
            fn ($key) => in_array($key, $this->fillable, true),
            ARRAY_FILTER_USE_KEY
        );
    }

    protected function assertTableDefined(): void
    {
        if ($this->table === '') {
            throw new \RuntimeException('Model table is not defined. Set protected $table in your model.');
        }
    }
}