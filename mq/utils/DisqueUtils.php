<?php

/**
 *
 * Created by PhpStorm.
 * User: mofuhao <mofh@pvc123.com>
 * Data: 2020/4/13
 * Time: 17:34
 */

namespace utils\mq\utils;

use Disque\Client;
use Disque\Connection\Credentials;
use herosphp\core\Loader;

class DisqueUtils
{

    private static $disque = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$disque)) {
            $configs = Loader::config('disque', 'mq');
            if (!$configs) {
                return false;
            }
            $nodes = [];
            foreach ($configs ?? [] as $k => $config) {
                $nodes[$k] = new Credentials(
                    $config['host'],
                    $config['port'],
                    $config['password'],
                    $config['connectionTimeout'],
                    $config['responseTimeout']
                );
            }
            if (empty($nodes)) {
                return false;
            }
            self::$disque = new Client($nodes);
        }
        return self::$disque;
    }
}
