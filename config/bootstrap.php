<?php

if (defined('APP_BOOTSTRAP_LOADED')) {
    return;
}

define('APP_BOOTSTRAP_LOADED', true);

$envFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';

if (!is_readable($envFile)) {
    return;
}

$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if ($lines === false) {
    return;
}

foreach ($lines as $line) {
    $trimmedLine = trim($line);

    if ($trimmedLine === '' || str_starts_with($trimmedLine, '#')) {
        continue;
    }

    $delimiterPosition = strpos($trimmedLine, '=');

    if ($delimiterPosition === false) {
        continue;
    }

    $key = trim(substr($trimmedLine, 0, $delimiterPosition));
    $value = trim(substr($trimmedLine, $delimiterPosition + 1));

    if ($key === '') {
        continue;
    }

    if (
        (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
        (str_starts_with($value, "'") && str_ends_with($value, "'"))
    ) {
        $value = substr($value, 1, -1);
    }

    if (getenv($key) === false) {
        putenv($key . '=' . $value);
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}
