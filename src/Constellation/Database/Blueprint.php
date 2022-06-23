<?php

namespace Constellation\Database;

/**
 * @class Blueprint
 */
class Blueprint
{
    private array $definitions = [];

    public function last()
    {
        return count($this->definitions) - 1;
    }

    public function appendDefinition(int $index, string $string)
    {
        $definition = $this->definitions[$index];
        $this->definitions[$index] = "$definition $string";
        return $this;
    }

    /**
     * Add a default value to column
     * @param string $separator Definition separator
     */
    public function getDefinitions(string $separator = ","): string
    {
        return implode($separator, $this->definitions);
    }

    /**
     * Add a default value to column
     * @param string $value Default value
     */
    public function default(string $value)
    {
        $this->appendDefinition($this->last(), "DEFAULT $value");
        return $this;
    }

    /**
     * Specify a column as unique index
     * @param string $attribute Unique attribute
     */
    public function unique(string $attribute)
    {
        $this->definitions[] = sprintf("UNIQUE KEY %s", $attribute);
        return $this;
    }

    /**
     * Specify a reference attribute for foreign key constraint
     * @param string $attribute Attribute of foreign key constraint
     */
    public function references(string $table_name, string $attribute)
    {
        $this->appendDefinition($this->last(), "REFERENCES $table_name($attribute)");
        return $this;
    }

    /**
     * Specify a ON DELETE properites of the constraint
     * @param string $action Action to take on delete
     */
    public function onDelete(string $action)
    {
        $this->appendDefinition($this->last(), "ON DELETE $action");
        return $this;
    }

    public function autoIncrement()
    {
        $this->appendDefinition($this->last(), "AUTO INCREMENT");
        return $this;
    }

    /**
     * Specify a ON UPDATE properites of the constraint
     * @param string $action Action to take on delete
     */
    public function onUpdate(string $action)
    {
        $this->appendDefinition($this->last(), "ON UPDATE $action");
        return $this;
    }

    /**
     * Specify an index (compound or composite)
     * @param array $attributes Indexed attribute
     */
    public function index(array $attributes)
    {
        return $this;
    }

    /**
     * Allow NULL values to be inserted into the column
     * @param boolean $value Explicit setting of null
     */
    public function nullable(bool $value = true)
    {
        $index = count($this->definitions) - 1;
        $definition = $this->definitions[$index];
        $this->definitions[$index] = str_replace(" NOT NULL", "", $definition);
        return $this;
    }

    /**
     * Specify a character set for the column
     * @param string $character_set Character set
     */
    public function charset(string $character_set = "utf8mb4")
    {
        return $this;
    }

    /**
     * Specify a collation for the column
     * @param string $collation Collation
     */
    public function collation(string $collation = "utf8mb4_unicode_ci")
    {
        return $this;
    }

    /**
     * Creates an auto-incrementing UNSIGNED BIGINT (primary key) column
     * @param string $attribute Name of attribute
     */
    public function bigIncrements(string $attribute)
    {
        $this->unsignedBigInteger($attribute)->autoIncrement();
        return $this;
    }

    /**
     * Creates a BIGINT column
     * @param string $attribute Name of attribute
     */
    public function bigInteger(string $attribute)
    {
        $this->definitions[] = sprintf("%s BIGINT NOT NULL", $attribute);
        return $this;
    }

    /**
     * Creates a BLOB column
     * @param string $attribute Name of attribute
     */
    public function binary(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a BOOLEAN column
     * @param string $attribute Name of attribute
     */
    public function boolean(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a CHAR column
     * @param string $attribute Name of attribute
     * @param int $length Length of char
     */
    public function char(string $attribute, int $length)
    {
        return $this;
    }

    /**
     * Creates a DATETIME column
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     */
    public function dateTime(string $attribute, int $precision = 0)
    {
        $this->definitions[] = sprintf("%s DATETIME(%s) NOT NULL", $attribute, $precision);
        return $this;
    }

    /**
     * Creates a DATE column
     * @param string $attribute Name of attribute
     */
    public function date(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a DECIMAL column
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     * @param int $scale Decimal digits
     */
    public function decimal(string $attribute, $precision = 8, $scale = 2)
    {
        return $this;
    }

    /**
     * Creates a DOUBLE column
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     * @param int $scale Decimal digits
     */
    public function double(string $attribute, $precision = 8, $scale = 2)
    {
        return $this;
    }

    /**
     * Creates an ENUM column
     * @param string $attribute Name of attribute
     * @param array $values Valid values of enum
     */
    public function enum(string $attribute, array $values)
    {
        return $this;
    }

    /**
     * Creates a FLOAT column
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     * @param int $scale Decimal digits
     */
    public function float(string $attribute, int $precision = 8, int $scale = 2)
    {
        return $this;
    }

    /**
     * Creates an foreign key column
     * @param string $attribute Name of attribute
     */
    public function foreignKey(string $attribute)
    {
        $this->definitions[] = sprintf("FOREIGN KEY (%s)", $attribute);
        return $this;
    }

    /**
     * Creates a GEOMETRY column
     * @param string $attribute Name of attribute
     */
    public function geometry(string $attribute)
    {
        return $this;
    }

    /**
     * Creates an auto-incrementing UNSIGNED BIGINT (primary key) column
     * Alias of bigIncrements
     * @param string $attribute Name of attribute
     */
    public function id(string $attribute)
    {
        $this->bigIncrements($attribute);
    }

    /**
     * Creates an auto-incrementing UNSIGNED INTEGER column
     * @param string $attribute Name of attribute
     */
    public function increments(string $attribute)
    {
        return $this;
    }

    /**
     * Add UNSIGNED attribute to column
     */
    public function unsigned()
    {
        $this->appendDefinition($this->last(), "UNSIGNED");
        return $this;
    }

    /**
     * Creates an INTEGER column
     * @param string $attribute Name of attribute
     */
    public function integer(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a JSON column
     * @param string $attribute Name of attribute
     */
    public function json(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a JSONB column
     * @param string $attribute Name of attribute
     */
    public function jsonb(string $attribute)
    {
        return $this;
    }

    /**
     * Creates an auto-incrementing UNSIGNED MEDIUMINT column
     * @param string $attribute Name of attribute
     */
    public function mediumIncrements(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a MEDIUMINT column
     * @param string $attribute Name of attribute
     */
    public function mediumInteger(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a MEDIUMTEXT column
     * @param string $attribute Name of attribute
     */
    public function mediumText(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a MULTILINESTRING column
     * @param string $attribute Name of attribute
     */
    public function multiLineString(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a MULTIPOINT column
     * @param string $attribute Name of attribute
     */
    public function multipoint(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a MULTIPOLYGON column
     * @param string $attribute Name of attribute
     */
    public function multiPolygon(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a POINT column
     * @param string $attribute Name of attribute
     */
    public function point(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a POLYGON column
     * @param string $attribute Name of attribute
     */
    public function polygon(string $attribute)
    {
        return $this;
    }

    /**
     * Creates an auto-incrementing UNSIGNED SMALLINT column
     * @param string $attribute Name of attribute
     */
    public function smallIncrements(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a SMALLINT column
     * @param string $attribute Name of attribute
     */
    public function smallInt(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a VARCHAR column
     * @param string $attribute Name of attribute
     * @param int $length Length of varchar
     */
    public function varchar(string $attribute, int $length = 255)
    {
        $this->definitions[] = sprintf("%s VARCHAR(%s) NOT NULL", $attribute, $length);
        return $this;
    }

    /**
     * Creates a TEXT column
     * @param string $attribute Name of attribute
     */
    public function text(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a TIME column
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     */
    public function time(string $attribute, int $precision)
    {
        return $this;
    }

    /**
     * Creates a TIMESTAMP column
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     */
    public function timestamp(string $attribute, int $precision = 0)
    {
        $this->definitions[] = sprintf("%s TIMESTAMP(%s) NOT NULL", $attribute, $precision);
        return $this;
    }

    /**
     * Creates created_at and updated_at columns
     * @param int $precision Total digits
     */
    public function timestamps(int $precision = 0)
    {
        $this->datetime("created_at");
        $this->timestamp("updated_at")->onUpdate("CURRENT_TIMESTAMP");
        return $this;
    }

    /**
     * Creates an auto-incrementing UNSIGNED TINYINT column
     * @param string $attribute Name of attribute
     */
    public function tinyIncrements(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a TINYINT column
     * @param string $attribute Name of attribute
     */
    public function tinyInteger(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a TINYTEXT column
     * @param string $attribute Name of attribute
     */
    public function tinyText(string $attribute)
    {
        return $this;
    }

    /**
     * Creates an UNSIGNED BIGINT column
     * @param string $attribute Name of attribute
     */
    public function unsignedBigInteger(string $attribute)
    {
        $this->bigInteger($attribute)->unsigned();
        return $this;
    }

    /**
     * Creates an UNSIGNED DECIMAL column
     * @param string $attribute Name of attribute
     * @param int $precision Total digits
     * @param int $scale Decimal digits
     */
    public function unsignedDecimal(
        string $attribute,
        int $precision,
        int $scale
    ) {
        return $this;
    }

    /**
     * Creates an UNSIGNED INTEGER column
     * @param string $attribute Name of attribute
     */
    public function unsignedInteger(string $attribute)
    {
        return $this;
    }

    /**
     * Creates an UNSIGNED MEDIUMINT column
     * @param string $attribute Name of attribute
     */
    public function unsignedMediumInteger(string $attribute)
    {
        return $this;
    }

    /**
     * Creates an UNSIGNED SMALLINT
     * @param string $attribute Name of attribute
     */
    public function unsignedSmallInteger(string $attribute)
    {
        return $this;
    }

    /**
     * Creates an UNSIGNED TINYINT
     * @param string $attribute Name of attribute
     */
    public function unsignedTinyInteger(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a UUID column
     * @param string $attribute Name of attribute
     */
    public function uuid(string $attribute)
    {
        return $this;
    }

    /**
     * Creates a YEAR column
     * @param string $attribute Name of attribute
     */
    public function year(string $attribute)
    {
        return $this;
    }
}
