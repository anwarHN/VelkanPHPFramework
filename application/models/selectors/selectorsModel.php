<?php
class selectorsModel extends model{
	public $lookup1;
	public $lookup2;
	
	function load($args=array()){
		$this->lookup1=new lookup(array("id"=>"lookup1","caption"=>"Buscar..."));
		$this->lookup1->setTitle("Prueba");
		$this->lookup1->setHeaders("Resultado");
		$this->lookup1->addListElement("0", "Prueba 1");
		$this->lookup1->addListElement("1", "Prueba 2");
		$this->lookup1->addListElement("2", "Prueba 3");
		$this->lookup1->addListElement("3", "Prueba 4");
		$this->lookup1->addListElement("4", "Prueba 5");
		
		$this->lookup2=new lookup(array("id"=>"lookup2"));
		$this->lookup2->setTitle("Prueba con filtros y base de datos");
		$this->lookup2->addFilter("number", "C&oacute;digo", "id");
		$this->lookup2->addFilter("", "Descripci&oacute;n", "txt_desc");
		$this->lookup2->setHeaders("C&oacute;digo, Descripci&oacute;n");
		$this->lookup2->getFromDataBase("lookup_test", "id,text","id","text");
	}
}