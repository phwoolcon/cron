# Cronjob 管理包

## 使用说明

请在使用的项目中添加配置文件 cron.php , 内容格式如下:


```php
<?php 
//例子
return [
    'process_untreated_queue' => [                  // 名称, 必须唯一
        'expression' => '* * * * *',                // cron 的执行规则
        'class' => 'Common\Library\QueueHelper',    // 执行的类名
        'method' => 'processUntreatedQueue'         // 执行的方法
    ],
    'update_currency' => [
        'expression' => '0 * * * *',
        'class' => 'Common\Library\Currency',
        'method' => 'updateCurrency',
    ],
];
```
