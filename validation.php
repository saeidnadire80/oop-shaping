<?php
class errorr{
    protected $eroors=[];
    public function set(string $name,string $value){
         $this->eroors[$name]=$value;
    }
    public function has($name){
        return isset($this->eroors[$name]);
    }
    public function get($name){
        if($this->has($name)){
            return $this->eroors[$name];
        }
    }
    public function request(string $request){
        if(isset($_REQUEST[$request]) && $_REQUEST[$request] != ''){
            return trim($_REQUEST[$request]);
        }else{
            return null;
        }
    }
}
?>