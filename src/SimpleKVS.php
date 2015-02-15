<?php
namespace Chatbox\SimpleKVS;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/11
 * Time: 21:49
 */

class SimpleKVS {

    /**
     * @param $type
     * @param $config
     * @return SimpleKVS
     */
    static public function load($type,$config){
        return new static(DriverLoader::load($type,$config));
    }

    /**
     * @var Driver\KVSDriverInterface
     */
    protected $driver;

    function __construct(\Chatbox\SimpleKVS\Driver\KVSDriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param $key
     * @return Model
     */
    public function get($key){
        return $this->driver->get($key);
    }

    public function set($key,$value){
        return $this->driver->set($key,$value);
    }

    public function update($key){

    }



} 