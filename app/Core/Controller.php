<?php
namespace App\Core;

class Controller
{
    protected function json($data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function view(string $name, array $data = []): void
    {
        extract($data);
        $file = __DIR__ . '/../../views/' . $name . '.php';
        if (file_exists($file)) require $file;
        else echo "View not found: $name";
    }

    protected function redirect(string $path): never
    {
        header('Location: ' . base_url($path));
        exit;
    }

    protected function getParam(string $key, $default = null)
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    protected function getInt(string $key, int $default = 0): int
    {
        return intval($this->getParam($key, $default));
    }

    protected function requireAuth(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!array_key_exists('escuela_id', $_SESSION) || $_SESSION['escuela_id'] === null || $_SESSION['escuela_id'] === '') {
            $this->redirect('/login');
        }
    }
}
