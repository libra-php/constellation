<?php 

namespace Constellation\Database;

/**
 * @class Schema
 */
class Schema
{
    public static function create(string $table_name, callable $callback)
    {
        $query = $callback();
        return $query;
    }

    public static function drop(string $table_name) {
    }
}
