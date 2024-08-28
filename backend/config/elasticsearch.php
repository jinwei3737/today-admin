<?php

return [
    'hosts' => [
        env('ELASTICSEARCH_HOST', 'elasticsearch:9200'),
    ],
    'password' => env('ELASTICSEARCH_PASSWORD', 'admin123'),
];



