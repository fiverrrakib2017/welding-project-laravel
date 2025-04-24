<?php

return [
    'default' => 'OLT1',
    'devices' => [
        'OLT1' => [
            'host' => env('SNMP_HOST'),
            'community' => env('SNMP_COMMUNITY', 'public'),
            'port' => env('SNMP_PORT', 161),
            'version' => '2c',
        ],
    ],
];


?>
