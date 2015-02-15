<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/11
 * Time: 21:55
 */

namespace Chatbox\SimpleKVS\Driver;

use Illuminate\Database\Capsule\Manager as Capsule;

class SimpleDB implements KVSDriverInterface{

    /**
     * @var \Illuminate\Database\Connection;
     */
    protected $connection;

    protected $table;

    protected $expiredIn = 3000;

    protected $updateOnAccess = false;

    function __construct(array $config)
    {
        $this->connection = $this->getConnection($config);
        $this->table = \Chatbox\Arr::get($config,"table");
    }

    /**
     * @param $config
     * @return \Illuminate\Database\Connection
     */
    protected function getConnection($config){
        $dbConfig = \Chatbox\Arr::get($config,"database",null);
        if($dbConfig){
            $capsule = new Capsule;
            $capsule->addConnection($dbConfig);
            return $capsule->getConnection();
        }else{
            return Capsule::connection();
        }
    }

    public function get($key)
    {
//        $this->connection->enableQueryLog();
        $builder = $this->getBuilder();
        $builder->select("*")->where("key","=",$key);
//        $builder->where("created_at","<",time());
        $builder->where("deleted_at",null);
        $result = $builder->first();
//        var_dump($result,$this->connection->getQueryLog());exit;
        if($result){
            $model = new \Chatbox\SimpleKVS\Model($result["key"],$result["value"]);
            $this->getBuilder()->where("key",$model->getKey())->update([
                "accessed_at" => date("Y-m-d H:i:s"),
            ]);
            return $model;
        }else{
            throw new \Exception("cant find value with the key $key");
        }
    }

    public function set($key,$value)
    {
        is_array($value) && ($value = json_encode($value));
        $this->getBuilder()->insert([
            "key" => $key,
            "value" => $value,
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
            "accessed_at" => date("Y-m-d H:i:s"),
            "deleted_at" => null,
        ]);
        return $key;
    }

    public function update($key,$value){
        is_array($value) && ($value = json_encode($value));
        $this->getBuilder()->update([
            "value" => $value,
            "updated_at" => date("Y-m-d H:i:s"),
        ])->where("key",$key);
    }

    public function delete($key){
        $this->getBuilder()->update([
            "deleted_at" => date("Y-m-d H:i:s")
        ])->where("key",$key);
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getBuilder(){
        return $this->connection->table($this->table);
    }

} 