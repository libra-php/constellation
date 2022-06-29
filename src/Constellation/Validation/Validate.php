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
}
