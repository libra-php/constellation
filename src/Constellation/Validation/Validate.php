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
        "string" => "%value must be a string",
        "email" => "%value must be a valid email address",
        "required" => "%field is a required field",
        "match" => "%field does not match",
        "min_length" => "%field is too short (min length: %rule_extra)",
        "max_length" => "%field is too long (max length: %rule_extra)",
        "uppercase" =>
            "%field requires at least %rule_extra uppercase character",
        "lowercase" =>
            "%field requires at least %rule_extra lowercase character",
        "symbol" => "%field requires at least %rule_extra symbol character",
        "reg_ex" => "%field is invalid",
    ];
    public static $errors = [];
    public static $custom = [];

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
        self::$errors[$replacements["%field"]][] = strtr(
            self::$messages[$item],
            $replacements
        );
    }

    public static function request(array $data, array $request_rules): ?stdClass
    {
        foreach ($request_rules as $request_item => $ruleset) {
            $value = $data[$request_item] ?? null;
            foreach ($ruleset as $rule_raw) {
                $rule_split = explode("=", $rule_raw);
                $rule = $rule_split[0];
                $extra = count($rule_split) == 2 ? $rule_split[1] : "";
                $result = match ($rule) {
                    "string" => self::isString($value),
                    "email" => self::isEmail($value),
                    "required" => self::isRequired($value),
                    "match" => self::isMatch($data, $request_item, $value),
                    "min_length" => self::isMinLength($value, $extra),
                    "max_length" => self::isMaxLength($value, $extra),
                    "uppercase" => self::isUppercase($value, $extra),
                    "lowercase" => self::isLowercase($value, $extra),
                    "symbol" => self::isSymbol($value, $extra),
                    "reg_ex" => self::regEx($value, $extra),
                    default => error_log(
                        "No default request validation rule [$rule] found"
                    ),
                };
                if (!$result) {
                    self::addError($rule, [
                        "%rule" => $rule,
                        "%rule_extra" => $extra,
                        "%field" => $request_item,
                        "%value" => $value,
                    ]);
                }
                foreach (self::$custom as $custom_rule => $callback) {
                    if ($custom_rule === $rule) {
                        error_log(
                            "Custom request validation rule [$rule] found"
                        );
                        if (!$callback($value)) {
                            self::addError($rule, [
                                "%rule" => $rule,
                                "%rule_extra" => $extra,
                                "%field" => $request_item,
                                "%value" => $value,
                            ]);
                        }
                    }
                }
            }
        }
        return count(self::$errors) == 0 ? (object) $data : null;
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
        return !is_null($value) && $value != "";
    }

    public static function isMatch($request_data, $item, $value)
    {
        if (!isset($request_data[$item . "_match"])) {
            return false;
        }
        return $request_data[$item . "_match"] === $value;
    }

    public static function isMinLength($value, $min_length)
    {
        return strlen($value) >= $min_length;
    }

    public static function isMaxLength($value, $max_length)
    {
        return strlen($value) <= $max_length;
    }

    public static function isUppercase($value, $count)
    {
        preg_match_all("/[A-Z]/", $value, $matches);
        return !empty($matches[0]) && count($matches) >= $count;
    }

    public static function isLowercase($value, $count)
    {
        preg_match_all("/[a-z]/", $value, $matches);
        return !empty($matches[0]) && count($matches) >= $count;
    }

    public static function isSymbol($value, $count)
    {
        preg_match_all("/[$&+,:;=?@#|'<>.^*()%!-]/", $value, $matches);
        return !empty($matches[0]) && count($matches) >= $count;
    }

    public static function regEx($value, $pattern)
    {
        return preg_match("/{$pattern}/", $value);
    }
}
