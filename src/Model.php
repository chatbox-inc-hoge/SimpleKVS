<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/11
 * Time: 21:50
 */

namespace Chatbox\SimpleKVS;

/**
 * Class Model
 * KVSに提供可能な形のデータを構成刷ることに注力するスコープ
 * @package Chatbox\SimpleKVS
 */
class Model{

    protected $key;

    protected $value;

    /**
     * 格納する際の配列の問題は考えない。
     * @param $key
     * @param $value
     */
    function __construct($key,$value)
    {
        $this->setKey($key);
        $this->setValue($value);
    }

    public function getKey(){
        return $this->key;
    }

    public function getValue(){
        return $this->value;
    }

    public function setKey($key){
        if(is_string($key)){
            $this->key = $key;
        }else{
            throw new \DomainException("key must be string");
        }
    }

    public function setValue($value){
        if(is_string($value)){
            $this->value = $value;
        }else{
            throw new \DomainException("value must be string");
        }
    }
}