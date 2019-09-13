<?php

namespace App;

/**
 * Class DB
 * @package App
 */
class DB
{
    protected $pdo;

    /**
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }

    /**
     * @param \PDO|null $pdo
     * @return DB
     */
    public function setPdo(?\PDO $pdo): self
    {
        $this->pdo = $pdo;

        self::__save($this);

        return $this;
    }

    /**
     * @return DB|null
     */
    public static function get(): ?DB
    {
        if (isset($GLOBALS['__DB'])) {
            return $GLOBALS['__DB'];
        }

        return null;
    }

    /**
     * @param string $query
     * @param array $data
     * @return array|bool
     */
    public static function execute(string $query, array $data = [])
    {
        $is_select_query = strpos(trim(strtoupper($query)), 'SELECT') === 0;

        $db = self::get();
        $statement = $db->getPdo()->prepare($query);
        $result = $statement->execute($data);

        if ($is_select_query) {
            $result = $statement->fetchAll();
        }

        self::__save($db);

        return $result;
    }

    /**
     * @param string $table
     * @param array|null $attributes
     * @return array
     */
    public static function select(string $table, ?array $attributes = null): array
    {
        if (!$attributes) {
            $attributes = '*';
        } else if (is_array($attributes)) {
            $attributes = join(', ', $attributes);
        }

        $query = "
            SELECT
                $attributes
            FROM
                $table
        ";

        return self::execute($query);
    }

    /**
     * @param string $table
     * @param int $id
     * @param array|null $attributes
     * @return array|null
     */
    public static function find(string $table, int $id, ?array $attributes = null): ?array
    {
        if (!$attributes) {
            $attributes = '*';
        } else {
            $attributes = join(', ', $attributes);
        }

        $query = "
            SELECT
                $attributes
            FROM
                $table
            WHERE
                id = :id
        ";

        $result = self::execute($query, [':id' => $id]);

        return ($result) ? $result[0] : null;
    }

    /**
     * @param string $table
     * @param array $attributes
     * @param array $data
     * @return bool
     */
    public static function insert(string $table, array $attributes, array $data): bool
    {
        $attributes = join(', ', $attributes);
        $values = join(', ', array_keys($data));

        $query = "
            INSERT INTO
                $table ($attributes)
            VALUES
                ($values)
        ";

        return self::execute($query, $data);
    }

    /**
     * @param string $table
     * @param int $id
     * @param array $attributes
     * @param array $data
     * @return bool
     */
    public static function update(string $table, int $id, array $attributes, array $data): bool
    {
        $values = [];

        foreach ($attributes as $attribute) {
            $values[] = $attribute . ' = :' . $attribute;
        }

        $values = join(', ', $values);

        $query = "
            UPDATE
                $table
            SET
                $values
            WHERE
                id = :id
        ";

        $data[':id'] = $id;

        return self::execute($query, $data);
    }

    /**
     * @param DB $db
     */
    protected static function __save(DB $db): void
    {
        $GLOBALS['__DB'] = $db;
    }

    /**
     * @return DB
     * @throws \Exception
     */
    public static function connect(): DB
    {
        if (self::get()) {
            throw new \Exception('A database connection has already been established.', 500);
        }

        try {
            $pdo = new \PDO('sqlite:' . __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'database.db');

            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $db = new DB;

            $db->setPdo($pdo);

            self::__save($db);

            return $db;
        } catch (\Exception $exception) {
            echo '<pre>';
            print_r($exception);
            echo '</pre>';

            exit(0);
        }
    }

    /**
     *
     */
    public function disconnect()
    {
        $this->setPdo(null);

        $GLOBALS['__DB'] = null;
    }

    /**
     * @return DB
     * @throws \Exception
     */
    public static function refresh(): DB
    {
        self::get()->disconnect();

        return self::connect();
    }

    /**
     * @return int
     */
    public static function getLastInsertedId(): int
    {
        return (int)self::get()->getPdo()->lastInsertId();
    }
}