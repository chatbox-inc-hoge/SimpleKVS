<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/11
 * Time: 21:55
 */

namespace Chatbox\SimpleKVS\Driver;

use Illuminate\Database\Capsule\Manager as Capsule;
use Chatbox\SimpleKVS\Model;
use Chatbox\Arr;

use \Illuminate\Database\Schema\Blueprint;

class SimpleDB implements KVSDriverInterface{

    static public function schema(){
        return function(Blueprint $blueprint){
            $blueprint->string("key");
            $blueprint->text("value");
            $blueprint->timestamp("created_at");
            $blueprint->timestamp("updated_at");
            $blueprint->timestamp("deleted_at")->nullable();
        };
    }

    /**
     * @var \Illuminate\Database\Connection;
     */
    protected $connection;
    protected $table;
    protected $expiredIn;
    protected $updateOnAccess;

    /**
     * time offset for test
     * @var int
     */
    protected $timeOffset = null;

    function __construct($config)
    {
        $this->connection = Capsule::connection();

        $this->table = Arr::get($config,"table",function(){
            throw new \DomainException("you should set tablename");
        });
        $this->expiredIn = (int) Arr::get($config,"expiredIn",3000);
        $this->updateOnAccess = (bool)Arr::get($config,"updateOnAccess",false);
    }

//    /**
//     * @param $config
//     * @return \Illuminate\Database\Connection
//     */
//    protected function getConnection($config){
//        $dbConfig = \Chatbox\Arr::get($config,"database",null);
//        if($dbConfig){
//            $capsule = new Capsule;
//            $capsule->addConnection($dbConfig);
//            return $capsule->getConnection();
//        }else{
//            return ;
//        }
//    }

    public function get($key)
    {
        $builder = $this->getBuilder();
        $builder->select("*")->where("key","=",$key);
        $builder->where("updated_at","<",$this->getTime());
        $builder->where("deleted_at",null);
        $result = $builder->first();
        if($result){
            $model = new Model($result["key"],$result["value"]);
            $this->updateOnAccess && $this->update($model);
            return $model;
        }else{
            return null;
        }
    }

    public function set(Model $model)
    {
        $time = $this->getTime();
        $this->getBuilder()->insert([
            "key" => $model->getKey(),
            "value" => $model->getValue(),
            "created_at" => $time,
            "updated_at" => $time,
            "deleted_at" => null,
        ]);
        return $model;
    }

    public function update(Model $model){
        $this->getBuilder()->update([
            "value" => $model->getValue(),
            "updated_at" => $this->getTime(),
        ])->where("key",$model->getKey());
    }

    public function delete(Model $model){
        $time = $this->getTime();
        $this->getBuilder()->update([
            "updated_at" => $time,
            "deleted_at" => $time
        ])->where("key",$model->getKey());
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getBuilder(){
        return $this->connection->table($this->table);
    }

    protected function getTime($fomat = "Y-m-d H:i:s"){
        $time = time();
        if($this->timeOffset){
            $time = $time - $this->timeOffset;
        }
        return date($fomat);
    }

    protected function setTime($offset){
        $this->timeOffset = $offset;
    }

} 