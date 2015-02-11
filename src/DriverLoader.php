<?php
namespace Chatbox\SimpleKVS;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/11
 * Time: 21:54
 */

class DriverLoader {

    /**
     * @param $type
     * @param $config
     * @return Driver\KVSDriverInterface
     */
    static public function load($type,$config){
        switch($type){
            case "eloquent":
                return new Driver\Eloquent($config);
            default:
                throw new \Exception("invalid type");
        }
    }
}