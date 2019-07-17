<?php

return [
    'phwoolcon/cron' => [
        'commands' => [
            99 => [
                'cron:execute' => 'Phwoolcon\Cron\Commands\CronCommand',
            ]
        ],
    ],
];
