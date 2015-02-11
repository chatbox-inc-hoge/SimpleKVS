<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/11
 * Time: 21:50
 */

namespace Chatbox\SimpleKVS;


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
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey(){
        return $this->key;
    }

    public function getValue(){
        return $this->value;
    }

    public function get($key,$value){
        return \Chatbox\Arr::get($this->getArrayValue(),$key,$value);
    }

    public function getArrayValue(){
        return json_decode($this->value,true)?:[];
    }
} 