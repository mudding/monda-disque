<?php

/**
 *
 * Created by PhpStorm.
 * User: mofuhao <mofh@pvc123.com>
 * Data: 2020/4/13
 * Time: 17:04
 */

namespace utils\mq;

use herosphp\core\Log;

class MqFactory
{
    private static $INSTANES = [];

    /**
     * @param $classPath
     * @return mixed
     */
    public static function create($classPath)
    {
        if (!isset(self::$INSTANES[$classPath])) {
            try {
                $reflect = new \ReflectionClass($classPath);
                $instance = $reflect->newInstance();
            } catch (\Exception $exception) {
                Log::error($exception);
            }
            self::$INSTANES[$classPath] = $instance;
        }
        return self::$INSTANES[$classPath];
    }
}