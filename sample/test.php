<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/11
 * Time: 22:07
 */
require __DIR__."/../vendor/autoload.php";

$driver = new \Chatbox\SimpleKVS\Driver\SimpleDB([
    "database" => [
        'driver'    => 'mysql',
        'host'      => '127.0.0.1',
        'database'  => 'needs',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ],
    "table" => "tmp_mail"
]);
//for($i=0;$i<100;$i++){
//    $key = \Chatbox\Str::random();
//    echo $key . PHP_EOL;
//}
//
//exit;


//$driver->set(\Chatbox\Str::random(),["piyo","piyo"]);

$driver->get("0000000");
