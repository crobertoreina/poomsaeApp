<?php
$basePath = dirname($_SERVER['SCRIPT_NAME']);
define('BASE_PATH', $basePath === '/' || $basePath === '\\' ? '' : $basePath);
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
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    return $protocol . '://' . $host . BASE_PATH . '/' . ltrim($path, '/');
}

function view($name, $data = []) {
    extract($data);
    $file = __DIR__ . '/../views/' . $name . '.php';
    if (file_exists($file)) require $file;
}

function beltColor(string $name): string {
    $map = [
        'blanco' => '#f5f5f5', 'amarillo' => '#ffd700',
        'verde' => '#4caf50', 'azul' => '#2196f3',
        'rojo' => '#f44336', 'negro' => '#212121',
        'marron' => '#795548', 'naranja' => '#ff8c00',
        'gris' => '#9e9e9e', 'morado' => '#9c27b0',
        'purpura' => '#7b1fa2',
    ];
    $key = strtolower(trim(preg_replace('/\s*\/\s*/', '/', $name)));
    return $map[$key] ?? '#e0e0e0';
}

function beltColorsAttr(string $name): string {
    $parts = preg_split('/[\/\-]/', $name);
    if (count($parts) >= 2) {
        return beltColor(trim($parts[0])) . '|' . beltColor(trim($parts[1]));
    }
    return beltColor($name);
}
