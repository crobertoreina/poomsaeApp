<?php
define('BASE_PATH', '/taek/nuevo');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'taekdb');

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) require_once $file;
});

function base_url($path = '') {
    return BASE_PATH . '/' . ltrim($path, '/');
}

function view($name, $data = []) {
    extract($data);
    $file = __DIR__ . '/../views/' . $name . '.php';
    if (file_exists($file)) require $file;
}
