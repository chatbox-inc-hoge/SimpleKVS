<?php
namespace Chatbox\SimpleKVS\Driver;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/11
 * Time: 21:53
 */
use Chatbox\SimpleKVS\Model;

interface KVSDriverInterface {

    /**
     * @param $key
     * @return \Chatbox\SimpleKVS\Model
     */
    public function get($key);

    /**
     * @param $key
     * @param $value
     * @return \Chatbox\SimpleKVS\Model
     */
    public function set(Model $model);

    /**
     * @param $key
     * @param $value
     * @return \Chatbox\SimpleKVS\Model
     */
    public function update(Model $model);

    /**
     * @param $key
     * @param $value
     * @return \Chatbox\SimpleKVS\Model
     */
    public function delete(Model $model);
}