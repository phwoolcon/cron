<?php

return [
    'appgame/cron' => [
        'commands' => [
            99 => [
                'cron:execute' => 'Appgame\Cron\Commands\CronCommand',
            ]
        ],
    ],
];
