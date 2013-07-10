<?php
class buttonModel extends model{
	public $button;
	
	public function load($args=array()){
		$this->button=new button(array("id"=>"boton1","caption"=>"Prueba de boton"));
		$this->button->addClass("btn-primary btn-mini");
		$this->button->setOnClick("alert('hola mundo');");
	}
}