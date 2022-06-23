<?php

declare(strict_types=1);

namespace Constellation\Tests\Container;

use PHPUnit\Framework\TestCase;
use Constellation\Database\Schema;
use Constellation\Database\Blueprint;

/**
 * @class SchemaTest
 */
class SchemaTest extends TestCase
{
    public function testSchemaCreateBlueprint()
    {
        $create_blueprint_schema = Schema::create("test", function(Blueprint $blueprint) {
            $blueprint->id("id");
            $blueprint->varchar("first_name");
            $blueprint->varchar("middle_name")->nullable();
            $blueprint->varchar("last_name");
            $blueprint->timestamps();
            return $blueprint;
        });
        print_r($create_blueprint_schema);
        die("----TEST----");
    }
}
