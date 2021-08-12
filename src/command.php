<?php

{{range services}} {{$name := .Name}} {{$service := service .Name}}

${{$name}} = array(
{{range $service}}
'ip'=>{{.Address}},
'port'=>{{.Port}}

){{end}};


$redis = new \LoadBalance\BalanceRedis();
$redis->roundRobin();