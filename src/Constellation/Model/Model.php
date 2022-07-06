<?php

namespace Constellation\Model;

use Constellation\Database\DB;

class Model
{
    private array $attributes = [];
    public function __construct(
        private DB $db,
        private string $table_name, 
        private string|array $key, 
        private null|string|array $id = null
    ) {

        if ($id) {
            
        }
    }

    public function init()
    {
        $result = $this->db->selectRow(
            "SELECT * FROM {$this->table_name} WHERE {$this->key} = %s",
            $this->id
        );
        print_r($result);die;
    }
}
