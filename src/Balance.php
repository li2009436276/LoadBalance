<?php


namespace LoadBalance;

class Balance
{


    private  $serviceName = '';
    private  $redis;

    public function __construct($serviceName)
    {
        $this->serviceName = $serviceName;
        $this->redis = new BalanceRedis();
    }

    /**
     * 加权轮训算法
     * @return bool|mixed
     */
    public  function roundRobin()
    {
        $service = $this->redis->lPop(Config::SERVICE_LIST_ROUND_ROBIN_PREFIX . $this->serviceName);
        if ($service) {

            $service = json_decode($service, true);
            $this->redis->rPush(Config::SERVICE_LIST_ROUND_ROBIN_PREFIX . $this->serviceName, json_encode($service));

            $service = 'tcp://' . $service['ip'] . ':' . $service['port'];
        }

        return $service;
    }
}