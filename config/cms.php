<?php
return [
    'content_types' => [
        'memory' => ['label' => 'Memory', 'icon' => '♡',  'color' => '#c9847a'],
        'blog'   => ['label' => 'Blog',   'icon' => '✍',  'color' => '#7a9ec9'],
        'news'   => ['label' => 'News',   'icon' => '📰',  'color' => '#7ac97a'],
    ],
    'memory_themes' => [
        'classic'   => 'Classic — Landing Page',
        'scrapbook' => 'Scrapbook — Polaroid & Collage',
        'film'      => 'Film — Cinematic Dark',
        'minimal'   => 'Minimal — Airy & Clean',
        'aurora'    => 'Aurora — Dreamy Gradient Glass',
        'editorial' => 'Editorial — Magazine Storytelling',
    ],
    'max_image_kb' => 10240,
    'max_music_kb' => 30720,
    'per_page'     => ['public' => 12, 'admin' => 20],
];

