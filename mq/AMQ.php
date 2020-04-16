<?php

/**
 *
 * Created by PhpStorm.
 * User: mofuhao <mofh@pvc123.com>
 * Data: 2020/4/16
 * Time: 11:05
 */

namespace utils\mq;

use utils\mq\interfaces\IMQ;

abstract class AMQ implements IMQ
{
    /**
     * @var int 毫秒精度的命令超时限制
     */
    protected $timeout = 500;

    /**
     * @var bool 要求服务器让命令尽快返回，并在后台执行将任务复制至其他节点的工作
     */
    protected $async = true;

    /**
     * @var int 指定任务需要复制至多少个节点
     */
    protected $replicate = 1;

    /**
     * @var int 指定任务在放入各个节点的队列之前， 需要等待多少秒钟
     */
    protected $delay = 1;

    /**
     * @var int  在未接到 ACK 回复的情况下， 节点在多少秒钟之后才会重新将任务放入待传递的队列里面。
     */
    protected $retry = 5;

}