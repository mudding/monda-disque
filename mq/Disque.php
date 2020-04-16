<?php
/**
 *
 * Created by PhpStorm.
 * User: mofuhao <mofh@pvc123.com>
 * Data: 2020/4/13
 * Time: 17:01
 */

namespace utils\mq;

use Disque\Queue\Job;
use herosphp\string\StringUtils;
use utils\mq\interfaces\IMQ;
use utils\mq\utils\DisqueUtils;

class Disque extends AMQ implements IMQ
{

    /**
     * @return array|bool
     */
    public function getHello()
    {
        DisqueUtils::getInstance()->connect();
        if (!DisqueUtils::getInstance()->isConnected()) {
            return false;
        }
        return DisqueUtils::getInstance()->hello();
    }

    /**
     * @return array|bool
     */
    public function getInfo()
    {
        DisqueUtils::getInstance()->connect();
        if (!DisqueUtils::getInstance()->isConnected()) {
            return false;
        }
        $infoString = DisqueUtils::getInstance()->info();
        $infoArr = preg_split('(\r\n)', $infoString, 0, PREG_SPLIT_NO_EMPTY);
        return $infoArr ?? [];
    }

    /**
     * @param string $queue
     * @param  $message
     * @return array|bool
     */
    public function push(string $queue, $message)
    {
        $job = new Job($message);
        $options = [
            'timeout' => $this->timeout,
            'replicate' => $this->replicate,
            'delay' => $this->delay,
            'retry' => $this->retry,
            'async' => $this->async
        ];
        $push = DisqueUtils::getInstance()->queue($queue)->push($job, $options);
        if ($push->getId()) {
//            return DisqueUtils::getInstance()->getJob($queue);
            return DisqueUtils::getInstance()->hello();
        }
        return false;
    }

    /**
     * @param string $queue
     * @param array $message
     * @param $delayTime
     * @return array|bool
     */
    public function pushSchedule(string $queue, $message, $delayTime)
    {
        $job = new Job($message);
        $push = DisqueUtils::getInstance()->queue($queue)->schedule($job, $delayTime);
        if ($push->getId()) {
            return DisqueUtils::getInstance()->getJob($queue);
        }
        return false;
    }

    /**
     * @param string $queue
     * @return bool|mixed|null
     */
    public function pullOne(string $queue)
    {
        $queue = DisqueUtils::getInstance()->queue($queue);
        while ($job = $queue->pull($this->timeout)) {
            //确认作业
            $queue->processed($job);
            return $job->getBody();
        }
        return false;
    }

    /**
     * @param string $jobId
     * @return array
     */
    public function showOneByJobId(string $jobId)
    {
        return DisqueUtils::getInstance()->show($jobId);
    }

}