<?php


namespace LoadBalance;

use LoadBalance\Config;

class BalanceRedis extends \Redis
{

    private $services = '';
    public function __construct($services = array())
    {

        $this->connect('127.0.0.1');

        $this->services = $services;
    }

    /**
     * 加权轮询算法
     */
    public function roundRobin($serviceName){

        $this->del(Config::SERVICE_LIST_ROUND_ROBIN_PREFIX.$serviceName);
        var_dump($serviceName);
        foreach ($this->services as $key=>$value) {

            for ($i=0; $i < $value['weight']; $i++) {

                $this->rPush(Config::SERVICE_LIST_ROUND_ROBIN_PREFIX.$serviceName,json_encode($value),1440);
            }
        }

    }
}