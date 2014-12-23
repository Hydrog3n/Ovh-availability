<?php
$feederjson = file_get_contents('./feeder.json');
$feeder = json_decode($feederjson);
$feeder[] = array ('139eg1', 'loic.vaille@gmail.com');
$encoded_feeder = json_encode($feeder);
file_put_contents('./feeder.json',$encoded_feeder.PHP_EOL);
