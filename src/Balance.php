<?php


namespace LoadBalance;

class Balance
{


    private static $serviceName = '';
    private static $redis;
    public function __construct($serviceName)
    {
        self::$serviceName = $serviceName;
        self::$redis = new BalanceRedis();
    }

    /**
     * 加权轮训算法
     * @return bool|mixed
     */
    public static function roundRobin(){

        $service = self::$redis->lPop(Config::SERVICE_LIST_ROUND_ROBIN_PREFIX.self::$serviceName);
        if ($service) {

            self::$redis->rPush(Config::SERVICE_LIST_ROUND_ROBIN_PREFIX.self::$serviceName,$service);
            $service = json_decode($service,true);
        }

        return $service;
    }
}