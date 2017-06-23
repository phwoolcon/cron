<?php

return [
    'luckyscape/cron' => [
        'commands' => [
            99 => [
                'cron:execute' => 'Luckyscape\Cron\Commands\CronCommand',
            ]
        ],
    ],
];
