<?php

namespace Constellation\Validation;

use Exception;
use stdClass;

/**
 * @class Validate
 */
class Validate
{
    public static $messages = [
        "string" => "%value: must be a string",
        "email" => "%value: must be a valid email address",
        "required" => "%field is a required field",
        "match" => "%field does not match",
    ];
    public static $errors = [];

    public static function keys(array $config, array $keys)
    {
        foreach ($keys as $key) {
            if (!key_exists($key, $config)) {
                throw new Exception("Configuration key [{$key}] is missing");
            }
        }
    }

    public static function addError($item, $replacements) 
    {
        self::$errors[$replacements["%field"]][] = strtr(self::$messages[$item], $replacements);
    }

    public static function request(array $data, array $request_rules): ?stdClass
    {
        foreach ($request_rules as $request_item => $ruleset) {
            $value = $data[$request_item] ?? null;
            foreach ($ruleset as $rule) {
                $result = match($rule) {
                    'string' => self::isString($value),
                    'email' => self::isEmail($value),
                    'required' => self::isRequired($value),
                    'match' => self::isMatch($data, $request_item, $value),
                };
                if (!$result) {
                    self::addError($rule, [
                        "%rule" => $rule,
                        "%field" => $request_item,
                        "%value" => $value
                    ]);
                }
            }
        }
        return count(self::$errors) == 0 ? (object)$data : null;
    }

    public static function isString($value)
    {
        return is_string($value);
    }

    public static function isEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function isRequired($value)
    {
        return !is_null($value);
    }

    public static function isMatch($request_data, $item, $value)
    {
        if (!isset($request_data[$item.'_match'])) return false;
        return $request_data[$item.'_match'] === $value;

    }
}
