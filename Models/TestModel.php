<?php 

namespace Models;
use Models\MyModel;
use Illuminate\Database\Capsule\Manager as DB;

class TestModel extends MyModel
{

    public function test(){

        $info = DB::table("test")->get();
        
        var_dump($info);
    }
}
