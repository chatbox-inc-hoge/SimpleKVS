<?php
namespace Chatbox\SimpleKVS;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/11
 * Time: 21:49
 */

use Chatbox\SimpleKVS\Driver\KVSDriverInterface;
use Chatbox\SimpleKVS\Model;

/**
 * Class SimpleKVS
 * ActiveRecordとしてデータ保持とアクセサ両方の機能を持つ
 * @package Chatbox\SimpleKVS
 */
class SimpleKVS {

    /** @var KVSDriverInterface */
    protected $driver;

    /** @var Model */
    protected $model;

    function __construct(KVSDriverInterface $driver,Model $model=null)
    {
        $this->driver = $driver;
        $this->model = $model;
    }

    /**
     * @param Model $model
     * @return static
     */
    public function newInstance(Model $model=null){
        return new static($this->driver,$model);
    }

    public function getKey(){
        if($this->model){
            return $this->model->getKey();
        }else{
            throw new \DomainException("cant get key from empty model");
        }
    }

    public function getValue(){
        if($this->model){
            return $this->model->getValue();
        }else{
            throw new \DomainException("cant get value from empty model");
        }
    }

    /**
     * @param $key
     * @return static
     */
    public function fetch($key){
        $model = $this->driver->get($key);
        if($model){
            return $this->newInstance($model);
        }else{
            return null;
        }
    }

    public function set($key,$value){
        $model = new Model($key,$value);
        $this->driver->set($model);
        return $this->newInstance($model);

    }

    public function update($newValue){
        if($this->model){
            $this->model->setValue($newValue);
            $this->driver->update($this->model);
        }else{
            throw new \DomainException("cant update value from empty model");
        }
    }

    public function delete(){
        if($this->model){
            $this->driver->delete($this->model);
        }else{
            throw new \DomainException("cant delete value from empty model");
        }
    }
}