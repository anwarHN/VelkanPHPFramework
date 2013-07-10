<?php
class widget_velkan_alert{
	private $params;
	
	public function setParams(array $args){
		$this->params=$args;
	}
	
	public function render(){
		$class=$this->params["class"];
		$message=$this->params["message"];
		
		$html="<div class='alert $class'>$message</div>";
		echo $html;
	}
}