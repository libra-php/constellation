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
    public function testSchemaUserCreateBlueprint()
    {
        $schema_create = Schema::create("users", function (Blueprint $table) {
            $table->id();
            $table->uuid("uuid");
            $table->varchar("name");
            $table->varchar("email");
            $table->binary("password", 40);
            $table->timestamps();
            $table->unique("email");
            $table->primaryKey("id");
        });
        $this->assertSame(
            "CREATE TABLE IF NOT EXISTS users (" .
                "id BIGINT UNSIGNED NOT NULL AUTO INCREMENT, " .
                "uuid BINARY(16) NOT NULL, " .
                "name VARCHAR(255) NOT NULL, " .
                "email VARCHAR(255) NOT NULL, " .
                "password BINARY(40) NOT NULL, " .
                "created_at DATETIME(0) NOT NULL, " .
                "updated_at TIMESTAMP(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP, " .
                "UNIQUE KEY (email), " .
                "PRIMARY KEY (id))",
            $schema_create
        );
    }
}
