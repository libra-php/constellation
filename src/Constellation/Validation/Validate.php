<?php

namespace Constellation\Validation;

use Exception;

/**
 * @class Validate
 */
class Validate
{
    public static function keys(array $config, array $keys)
    {
        foreach ($keys as $key) {
            if (!key_exists($key, $config)) {
                throw new Exception("Configuration key [{$key}] is missing");
            }
        }
    }

    public static function request(string $request_item, array $ruleset)
    {
        // IMPLEMENT ME!
    }
}
