<?php

define('DIR_ROOT', dirname(__DIR__));

require_once DIR_ROOT . '/vendor/autoload.php';

if (!function_exists('extract_namespace'))
{
    /**
     * Extracts the namespace name from a PHP file.
     *
     * @param string $filename The file to extract the namespace from.
     *
     * @return string|null The namespace name found, NULL otherwise.
     */
    function extract_namespace(string $filename): ?string
    {
        if (($handle = fopen($filename, 'rb'))) {
            while (($line = fgets($handle)) !== false) {
                if (preg_match("/^namespace\s+([0-9A-Za-z\\\\]+)\s*;\s*$/i", $line, $matches)) {
                    return rtrim(trim($matches[1]), ';');
                }
            }
            fclose($handle);
        }

        return null;
    }
}
