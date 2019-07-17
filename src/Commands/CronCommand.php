<?php
namespace Phwoolcon\Cron\Commands;

use Phwoolcon\Cron\Models\Cron;
use Config;
use Log;
use Phwoolcon\Cron\Library\TdCron;
use Phwoolcon\Cli\Command;

class CronCommand extends Command
{
    protected $initializedJobs;
    protected $jobs;
    protected $now;

    protected function configure()
    {
        $this->setDescription('Execute cron jobs.');
    }

    public function fire()
    {
        $this->now = strtotime(date('Y-n-j H:i'));
        $this->cron();
    }


    protected function cron()
    {
        restore_error_handler();
        restore_exception_handler();
        $this->initializedJobs = [];
        /** @var Cron[] $jobs */
        $jobs = Cron::findSimple(['status' => Cron::STATUS_INITIALIZED]);

        // 已存在 cron (initialized 状态)
        if ($jobs) {
            foreach ($jobs as $data) {
                $this->initializedJobs[(string)$data->name] = $data;
            }
        }

        /**
         * 新 cron
         */
        foreach ($this->getCronJobs() as $name => $cronJob) {
            if (isset($cronJob['expression'])) {
                $expression = $cronJob['expression'];
            } else {
                Log::error('Cron expression is required for cron job "' . $name . '"');
                continue;
            }
            if ($this->now != TdCron::getNextOccurrence($expression, $this->now)) {
                continue;
            }
            $cronJob['name'] = $name;
            $cron = isset($this->initializedJobs[$name]) ?
                        $this->initializedJobs[$name] : ($this->initializedJobs[$name] = new Cron());
            $cron->cronInitialize((array)$cronJob);
        }

        /* @var $cron Cron 处理 */
        foreach ($this->initializedJobs as $cron) {
            $cron->run();
        }

    }


    /**
     * Get All Defined Cron Jobs
     * 获取配置
     * @return array
     */
    public function getCronJobs()
    {
        $list = Config::get('cron');
        if (is_null($list)) {
            $this->error('No cron list');
            $this->info('Please create config file name "cron".');
            exit();
        }
        if ($this->jobs === null) {
            $this->jobs = $list;
        }
        return $this->jobs;
    }
}
