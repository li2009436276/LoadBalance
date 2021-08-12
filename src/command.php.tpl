<?php
  include_once "BalanceRedis.php";
  include_once "Config.php";
{{range services}} {{$name := .Name}} {{$service := service .Name}}
${{$name}} = array(
{{range $service}}
    array(
      'ip'=>'{{.Address}}',
      'port'=>'{{.Port}}',
      'weight'=>1,
    ),
  {{end}}
);
$redis = new \LoadBalance\BalanceRedis(${{$name}});
$redis->roundRobin('{{$name}}');

    {{end}}


