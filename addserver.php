<?php
$serverjson = file_get_contents('./servers.json');
$server = json_decode($serverjson);
$server[] = array("ref" => "150sk10", "name" => "Kimsufi - KS-1");
$encoded_server = json_encode($server);
file_put_contents('./servers.json',$encoded_server.PHP_EOL);
