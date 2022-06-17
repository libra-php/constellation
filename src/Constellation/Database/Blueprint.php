<?php

namespace Constellation\Database;

/**
 * @class Blueprint
 */
class Blueprint
{
    /**
     * Add a default value to column
     * @param string $value Default value
     */
    public function default(string $value)
    {

    }

    /**
     * Specify a column as unique index
     * @param string $attribute Unique attribute
     */
    public function unique()
    {

    }

    /**
     * Specify a reference attribute for foreign key constraint
     * @param string $attribute Attribute of foreign key constraint
     */
    public function references(string $attribute)
    {

    }

    /**
     * Specify a table for foreign key constraint
     * @param string $attribute Table name of foreign key constraint
     */
    public function on(string $table_name)
    {

    }

    /**
     * Specify a ON DELETE properites of the constraint
     * @param string $action Action to take on delete
     */
    public function onDelete(string $action)
    {

    }

    /**
     * Specify a ON UPDATE properites of the constraint
     * @param string $action Action to take on delete
     */
    public function onUpdate(string $action)
    {

    }

    /**
     * Specify a reference table for foreign key constraint
     * @param string $table_name Table of foreign key constraint
     */
    public function unique(string $table_name)
    {

    }

    /**
     * Specify an index (compound or composite)
     * @param array $attributes Indexed attribute
     */
    public function index(array $attributes)
    {

    }

    /**
     * Allow NULL values to be inserted into the column
     * @param boolean $value Explicit setting of null
     */
    public function nullable(bool $value = true)
    {

    }

    /**
     * Specify a character set for the column
     * @param string $character_set Character set
     */
    public function charset(string $character_set = "utf8mb4")
    {

    }

    /**
     * Specify a collation for the column
     * @param string $collation Collation
     */
    public function collation(string $collation = "utf8mb4_unicode_ci")
    {

    }

    /**
     * Creates an auto-incrementing UNSIGNED BIGINT (primary key) column
     * @param string $attribute Name of attribute
     */
    public function bigIncrements(string $attribute)
    {

    }

    /**
     * Creates a BIGINT column
     * @param string $attribute Name of attribute
     */
    public function bigInteger(string $attribute)
    {

    }

    /**
     * Creates a BLOB column
     * @param string $attribute Name of attribute
     */
    public function binary(string $attribute)
    {

    }

    /**
     * Creates a BOOLEAN column
     * @param string $attribute Name of attribute
     */
    public function boolean(string $attribute)
    {

    }

    /**
     * Creates a CHAR column
     * @param string $attribute Name of attribute
     * @param int $length Length of char
     */
    public function char(string $attribute, int $length)
    {

    }

    /**
     * Creates a DATETIME column
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     */
    public function dateTime(string $attribute, int $precision)
    {

    }

    /**
     * Creates a DATE column
     * @param string $attribute Name of attribute
     */
    public function date(string $attribute)
    {

    }

    /**
     * Creates a DECIMAL column
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     * @param int $scale Decimal digits
     */
    public function decimal(string $attribute, $precision = 8, $scale = 2)
    {

    }

    /**
     * Creates a DOUBLE column
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     * @param int $scale Decimal digits
     */
    public function double(string $attribute, $precision = 8, $scale = 2)
    {

    }

    /**
     * Creates an ENUM column
     * @param string $attribute Name of attribute
     * @param array $values Valid values of enum
     */
    public function enum(string $attribute, array $values)
    {

    }

    /**
     * Creates a FLOAT column
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     * @param int $scale Decimal digits
     */
    public function float(string $attribute, int $precision = 8, int $scale = 2)
    {

    }

    /**
     * Creates an UNSIGNED BIGINT column
     * @param string $attribute Name of attribute
     */
    public function foreignId(string $attribute)
    {

    }

    /**
     * Creates a GEOMETRY column
     * @param string $attribute Name of attribute
     */
    public function geometry(string $attribute)
    {

    }

    /**
     * Creates an auto-incrementing UNSIGNED BIGINT (primary key) column
     * Alias of bigIncrements
     * @param string $attribute Name of attribute
     */
    public function id(string $attribute)
    {
        
    }

    /**
     * Creates an auto-incrementing UNSIGNED INTEGER column 
     * @param string $attribute Name of attribute
     */
    public function increments(string $attribute)
    {

    }

    /**
     * Creates an INTEGER column
     * @param string $attribute Name of attribute
     */
    public function integer(string $attribute)
    {

    }

    /**
     * Creates a JSON column
     * @param string $attribute Name of attribute
     */
    public function json(string $attribute)
    {

    }

    /**
     * Creates a JSONB column
     * @param string $attribute Name of attribute
     */
    public function jsonb(string $attribute)
    {

    }

    /**
     * Creates an auto-incrementing UNSIGNED MEDIUMINT column
     * @param string $attribute Name of attribute
     */
    public function mediumIncrements(string $attribute)
    {

    }

    /**
     * Creates a MEDIUMINT column
     * @param string $attribute Name of attribute
     */
    public function mediumInteger(string $attribute)
    {

    }

    /**
     * Creates a MEDIUMTEXT column
     * @param string $attribute Name of attribute
     */
    public function mediumText(string $attribute)
    {

    }

    /**
     * Creates a MULTILINESTRING column 
     * @param string $attribute Name of attribute
     */
    public function multiLineString(string $attribute)
    {

    }

    /**
     * Creates a MULTIPOINT column
     * @param string $attribute Name of attribute
     */
    public function multipoint(string $attribute)
    {

    }

    /**
     * Creates a MULTIPOLYGON column
     * @param string $attribute Name of attribute
     */
    public function multiPolygon(string $attribute)
    {

    }

    /**
     * Creates a POINT column
     * @param string $attribute Name of attribute
     */
    public function point(string $attribute)
    {

    }

    /**
     * Creates a POLYGON column
     * @param string $attribute Name of attribute
     */
    public function polygon(string $attribute)
    {

    }

    /**
     * Creates an auto-incrementing UNSIGNED SMALLINT column
     * @param string $attribute Name of attribute
     */
    public function smallIncrements(string $attribute)
    {

    }

    /**
     * Creates a SMALLINT column
     * @param string $attribute Name of attribute
     */
    public function smallInt(string $attribute)
    {

    }

    /**
     * Creates a VARCHAR column 
     * @param string $attribute Name of attribute
     * @param int $length Length of varchar
     */
    public function varchar(string $attribute, int $length)
    {

    }

    /**
     * Creates a TEXT column
     * @param string $attribute Name of attribute
     */
    public function text(string $attribute)
    {

    }

    /**
     * Creates a TIME column
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     */
    public function time(string $attribute, int $precision)
    {

    }

    /**
     * Creates a TIMESTAMP column 
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     */
    public function timestamp(string $attribute, int $precision)
    {

    }

    /**
     * Creates created_at and updated_at columns
     * @param int $precision Total digits
     */
    public function timestamps(int $precision)
    {

    }

    /**
     * Creates an auto-incrementing UNSIGNED TINYINT column
     * @param string $attribute Name of attribute
     */
    public function tinyIncrements(string $attribute)
    {

    }

    /**
     * Creates a TINYINT column
     * @param string $attribute Name of attribute
     */
    public function tinyInteger(string $attribute)
    {

    }

    /**
     * Creates a TINYTEXT column 
     * @param string $attribute Name of attribute
     */
    public function tinyText(string $attribute)
    {

    }

    /**
     * Creates an UNSIGNED BIGINT column
     * @param string $attribute Name of attribute
     */
    public function unsignedBigInteger(string $attribute)
    {

    }

    /**
     * Creates an UNSIGNED DECIMAL column
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     * @param int $scale Decimal digits
     */
    public function unsignedDecimal(string $attribute, int $precision, int $scale)
    {

    }

    /**
     * Creates an UNSIGNED INTEGER column
     * @param string $attribute Name of attribute
     */
    public function unsignedInteger(string $attribute)
    {

    }

    /**
     * Creates an UNSIGNED MEDIUMINT column
     * @param string $attribute Name of attribute
     */
    public function unsignedMediumInteger(string $attribute)
    {

    }

    /**
     * Creates an UNSIGNED SMALLINT
     * @param string $attribute Name of attribute
     */
    public function unsignedSmallInteger(string $attribute)
    {

    }

    /**
     * Creates an UNSIGNED TINYINT
     * @param string $attribute Name of attribute
     */
    public function unsignedTinyInteger(string $attribute)
    {

    }

    /**
     * Creates a UUID column
     * @param string $attribute Name of attribute
     */
    public function uuid(string $attribute)
    {

    }

    /**
     * Creates a YEAR column
     * @param string $attribute Name of attribute
     */
    public function year(string $attribute)
    {

    }
}
