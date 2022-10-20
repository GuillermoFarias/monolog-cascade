<?php

namespace Cascade;

/**
 * Class Util.
 */
class Util
{
    /**
     * Convert a string from snake_case to camelCase.
     *
     * If the input is not a string, null is returned.
     *
     * @param string $input Input snake_case string
     *
     * @return string Output camelCase string
     */
    public static function snakeToCamelCase(string $input) : string
    {
        $output = (string) preg_replace_callback('/(^|_)+(.)/', function ($match) {
            return strtoupper($match[2]);
        }, $input);

        return lcfirst($output);
    }
}
