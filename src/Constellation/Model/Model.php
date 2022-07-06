<?php

namespace Constellation\Model;

use Constellation\Database\DB;
use PDO;

class Model
{
    private array $attributes = [];
    public function __construct(
        private DB $db,
        private string $table,
        private array $key,
        private ?array $id = null
    ) {
        $this->loadAttributes();
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
            }
        } else {
            $result = $this->db->run("DESCRIBE $this->table")->fetchAll(PDO::FETCH_COLUMN);
            if ($result) {
                $this->attributes = $result;
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

    public function update()
    {
        $update_statement = $this->stmt($this->attributeKeys(), ", ");
        $where_clause = $this->stmt($this->key, " AND ");
        return $this->db->run(
            "UPDATE $this->table 
            SET $update_statement 
            WHERE $where_clause",
            [...$this->attributeValues(), ...$this->id]
        );
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
