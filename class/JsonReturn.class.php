<?php
class JsonReturn{
	public $dieAfterConmplete = true;
	public $values = array(
		"result" => false,
		"message" => ""
	);
	public function __construct(){
		
	}
	public function success(){
		$this->values["result"] = true;
		$this->finish();
	}
	public function fail(){
		$this->values["result"] = false;
		$this->finish();
	}
	private function finish(){
		echo(json_encode($this->values));
		if($this->dieAfterConmplete){
			die();
		}
	}
	public function addValue($param,$val){
		$this->values[$param] = $val;
	}
	public function setValue($param,$val){
		$this->values[$param] = $val;
	}
	public function setMessage($val){
		$this->setValue("message",$val);
	}
}
?>