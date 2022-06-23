<?php

namespace Constellation\Database;

use Closure;

/**
 * @class Schema
 */
class Schema
{
    public static function create(string $table_name, Closure $callback)
    {
        $blueprint = new Blueprint();
        $callback($blueprint);
        return sprintf(
            "CREATE TABLE IF NOT EXISTS %s (%s)",
            $table_name,
            $blueprint->getDefinitions()
        );
    }

    public static function drop(string $table_name)
    {
        return sprintf("DROP TABLE IF EXISTS %s", $table_name);
    }
}
