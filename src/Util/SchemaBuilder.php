<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/11
 * Time: 22:18
 */

namespace Chatbox\SimpleKVS\Util;

use \Illuminate\Database\Schema\Blueprint;

class SchemaBuilder {

    static public function generate(){
        return function(Blueprint $blueprint){
            $blueprint->string("key");
            $blueprint->text("value");
            $blueprint->timestamp("created_at");
            $blueprint->timestamp("updated_at");
            $blueprint->timestamp("accessed_at");
            $blueprint->timestamp("deleted_at")->nullable();
        };
    }
}
