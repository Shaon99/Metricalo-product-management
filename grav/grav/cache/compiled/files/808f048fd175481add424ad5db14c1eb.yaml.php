<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/user/plugins/productfetcher/blueprints.yaml',
    'modified' => 1724381477,
    'size' => 390,
    'data' => [
        'name' => 'Product Fetcher',
        'version' => '1.0.0',
        'description' => 'Fetch and display products from an API.',
        'icon' => 'cart',
        'author' => [
            'name' => 'shaon',
            'email' => 'shaon@example.com'
        ],
        'form' => [
            'validation' => 'loose',
            'fields' => [
                'enabled' => [
                    'type' => 'toggle',
                    'label' => 'Plugin status',
                    'highlight' => 1,
                    'default' => 1,
                    'options' => [
                        1 => 'Enabled',
                        0 => 'Disabled'
                    ],
                    'validate' => [
                        'type' => 'bool'
                    ]
                ]
            ]
        ]
    ]
];
