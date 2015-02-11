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
    function __invoke()
    {
        if(func_num_args() === 1 && ($blueprint = func_get_arg(0)) && $blueprint instanceof Blueprint){
            $blueprint->string("key",true);
            $blueprint->text("value");
            $blueprint->timestamp("createdAt");
            $blueprint->timestamp("updatedAt");
            $blueprint->timestamp("accessAt");
            $blueprint->timestamp("expiredAt");
            $blueprint->timestamp("deletedAt");
        }
    }

}
