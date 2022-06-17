<?php

namespace Constellation\Database;

use Constellation\Container\Container;
use Constellation\Validation\Validate;
use PDO;

class DB
{
    protected static $instance;
    private $pdo;
    private $time;

    public function __construct(private array $config)
    {
        Validate::keys($this->config, ["type"]);
        $this->establishConnection();
    }

    public function __call($method, $args)
    {
        return $this->pdo->$method(...$args);
    }

    public static function sql()
    {
        return self::getInstance();
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = Container::getInstance()->get(Database::class);
        }

        return static::$instance;
    }

    private function establishConnection()
    {
        match ($this->config['type']) {
            "mysql" => $this->mysql(),
            "pgsql" => $this->pgsql(),
            "sqlite" => $this->sqlite(),
        };
    }

    private function mysql()
    {
        Validate::keys($this->config, ["host", "port", "dbname", "username", "password"]);
        extract($this->config);
        $dsn = sprintf("mysql:host=%s;port=%s;dbname=%s", $host, $port, $dbname);
        $this->pdo = new PDO($dsn, $username, $password);
    }

    private function pgsql()
    {
        Validate::keys($this->config, ["host", "port", "dbname", "username", "password"]);
        extract($this->config);
        $dsn = sprintf("pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s;", $host, $port, $dbname, $username, $password);
        $this->pdo = new PDO($dsn);
    }

    private function sqlite()
    {
        Validate::keys($this->config, ["path"]);
        extract($this->config);
        $dsn = sprintf("sqlite:%s", $path);
        $this->pdo = new PDO($dsn);
    }

    public function run(string $query, ...$args)
    {
        $this->time = microtime(true);
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(...$args);
        $this->time = microtime(true) - $this->time;
        if ($this->time > 1) {
            error_log("DB: slow query took {$this->time}: $query");
        }
        return $stmt;
    }

    public function selectRow(string $query, ...$args)
    {
        return $this->run($query, $args)->fetchObject();
    }

    public function selectMany(string $query, ...$args)
    {
        return $this->run($query, $args)->fetchAll(PDO::FETCH_OBJ);
    }

    public function selectVar(string $query, ...$vars)
    {
        $result =  (array)$this->selectOne($query, ...$vars);
        $var = array_values($result);
        return $var[0];
    }
}
