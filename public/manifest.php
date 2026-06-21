<?php
header('Content-Type: application/json');
header('Cache-Control: no-store');
?>
{
  "name": "Poomsae - Sistema de Evaluación",
  "short_name": "Poomsae",
  "description": "Sistema de evaluación de Poomsae para Dojangs de Taekwondo",
  "start_url": "<?= rtrim(BASE_PATH, '/') ?>/login",
  "display": "standalone",
  "orientation": "portrait",
  "background_color": "#f5f5dc",
  "theme_color": "#1b5e20",
  "scope": "<?= rtrim(BASE_PATH, '/') ?>/",
  "icons": [
    {
      "src": "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'%3E%3Crect width='192' height='192' rx='32' fill='%231b5e20'/%3E%3Ctext x='96' y='130' font-size='100' text-anchor='middle' fill='white'%3E🥋%3C/text%3E%3C/svg%3E",
      "sizes": "192x192",
      "type": "image/svg+xml",
      "purpose": "any maskable"
    },
    {
      "src": "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3Crect width='512' height='512' rx='64' fill='%231b5e20'/%3E%3Ctext x='256' y='350' font-size='200' text-anchor='middle' fill='white'%3E🥋%3C/text%3E%3C/svg%3E",
      "sizes": "512x512",
      "type": "image/svg+xml",
      "purpose": "any maskable"
    }
  ]
}
