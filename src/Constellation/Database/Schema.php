<?php

namespace Constellation\Database;

/**
 * @class Schema
 */
class Schema
{
    public static function create(string $table_name, callable $blueprint)
    {
        $create_table = $blueprint(new Blueprint);
        return sprintf("CREATE TABLE IF NOT EXISTS %s (%s)", $table_name, $create_table->getDefinitions());
    }

    public static function drop(string $table_name)
    {
        return sprintf("DROP TABLE IF EXISTS %s", $table_name);
    }
}
