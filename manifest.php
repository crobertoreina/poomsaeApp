<?php
header('Content-Type: application/json');
header('Cache-Control: no-store');
echo json_encode([
    'name' => 'Poomsae - Sistema de Evaluación',
    'short_name' => 'Poomsae',
    'description' => 'Sistema de evaluación de Poomsae para Dojangs de Taekwondo',
    'start_url' => BASE_PATH . '/login',
    'display' => 'standalone',
    'orientation' => 'portrait',
    'background_color' => '#f5f5dc',
    'theme_color' => '#1b5e20',
    'scope' => BASE_PATH . '/',
    'icons' => [
        [
            'src' => 'data:image/svg+xml,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 192"><rect width="192" height="192" rx="32" fill="#1b5e20"/><text x="96" y="130" font-size="100" text-anchor="middle" fill="white">🥋</text></svg>'),
            'sizes' => '192x192',
            'type' => 'image/svg+xml',
            'purpose' => 'any maskable',
        ],
        [
            'src' => 'data:image/svg+xml,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><rect width="512" height="512" rx="64" fill="#1b5e20"/><text x="256" y="350" font-size="200" text-anchor="middle" fill="white">🥋</text></svg>'),
            'sizes' => '512x512',
            'type' => 'image/svg+xml',
            'purpose' => 'any maskable',
        ],
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
