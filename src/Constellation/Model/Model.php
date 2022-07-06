<?php

namespace Constellation\Model;

use Constellation\Database\DB;
use PDO;

class Model
{
    private array $attributes = [];
    private bool $loaded = false;
    private DB $db;
    public function __construct(
        private string $table,
        private array $key,
        private ?array $id = null
    ) {
        $this->db = DB::getInstance();
        $this->loadAttributes();
    }

    public static function find(?array $id)
    {
        $class = static::class;
        $model = new $class($id);
        return $model->isLoaded() ? $model : null;
    }

    public static function create(array $attributes)
    {
        $class = static::class;
        $model = new $class();
        if ($model->insert($attributes)) {
            return $model->isLoaded() ? $model : null;
        }
        return null;
    }

    public static function remove(?array $id)
    {
        $class = static::class;
        $model = new $class($id);
        if ($model && $model->delete()) {
            return true;
        }
        return null;
    }

    public function refresh()
    {
        $this->loadAttributes();
    }

    public function isLoaded()
    {
        return $this->loaded;
    }

    public function loadAttributes()
    {
        if ($this->id) {
            $where_clause = $this->stmt($this->key, " AND ");
            $result = $this->db
                ->run(
                    "SELECT * 
                FROM $this->table 
                WHERE $where_clause",
                    $this->id
                )
                ->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                $this->attributes = $result[0];
                $this->loaded = true;
            }
        } else {
            $result = $this->db
                ->run("DESCRIBE $this->table")
                ->fetchAll(PDO::FETCH_COLUMN);
            if ($result) {
                foreach ($result as $one) {
                    $this->attributes[$one] = null;
                }
            }
        }
    }

    private function stmt(array $list, $seperator)
    {
        foreach ($list as $one) {
            $clause[] = "$one = ?";
        }
        return implode($seperator, $clause);
    }

    private function attributeKeys()
    {
        return array_keys($this->attributes);
    }

    private function attributeValues()
    {
        return array_values($this->attributes);
    }

    public function insert(array $attributes)
    {
        $columns = array_keys($attributes);
        $values = array_values($attributes);
        $update_statement = $this->stmt($columns, ", ");
        $result = $this->db->run(
            "INSERT INTO $this->table 
            SET $update_statement",
            $values
        );
        if ($result) $this->refresh();
        return $result;
    }

    public function update(array $attributes)
    {
        $columns = array_keys($attributes);
        $values = array_values($attributes);
        $update_statement = $this->stmt($columns, ", ");
        $where_clause = $this->stmt($this->key, " AND ");
        $result = $this->db->run(
            "UPDATE $this->table 
            SET $update_statement 
            WHERE $where_clause",
            [...$values, ...$this->id]
        );
        if ($result) $this->refresh();
        return $result;
    }

    public function delete()
    {
        $where_clause = $this->stmt($this->key, " AND ");
        $result = $this->db->run(
            "DELETE FROM $this->table 
            WHERE $where_clause",
            $this->id
        );
        if ($result) {
            $this->id = null;
            $this->refresh();
        }
        return $result;
    }

    public function __get($name)
    {
        return $this->attributes[$name];
    }

    public function __set($name, $value)
    {
        return $this->attributes[$name] = $value;
    }
}
