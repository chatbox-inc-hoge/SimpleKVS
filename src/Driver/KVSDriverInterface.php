<?php
namespace Chatbox\SimpleKVS\Driver;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/11
 * Time: 21:53
 */

interface KVSDriverInterface {

    /**
     * @param $key
     * @return \Chatbox\SimpleKVS\Model
     * @throw \Exception
     */
    public function get($key);

    /**
     * @param $key
     * @param $value
     * @return \Chatbox\SimpleKVS\Model
     */
    public function set($key,$value);

    public function update($key,$value);

    public function delete($key);
}