<?php
namespace App\Service;

class MyService{

    private $m;

    public function __construct(){
        $this -> m = "test service";
    }

    public function msg() : String {
        return "my service";
    }
    
    public function msg2() : String {

        return "my service 2";
    }
  
    public function get_m() : String {

        return $this -> m;
    }

}
?>