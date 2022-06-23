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
        $schema_create = Schema::create("test", function (
            Blueprint $blueprint
        ) {
            $blueprint->id("id");
            $blueprint->varchar("email");
            $blueprint->varchar("name")->nullable();
            $blueprint->timestamps();
            $blueprint->primaryKey("id");
            return $blueprint;
        });
        $this->assertSame(
            "CREATE TABLE IF NOT EXISTS test (id BIGINT UNSIGNED NOT NULL AUTO INCREMENT, email VARCHAR(255) NOT NULL, name VARCHAR(255), created_at DATETIME(0) NOT NULL, updated_at TIMESTAMP(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (id))",
            $schema_create
        );
    }
}
