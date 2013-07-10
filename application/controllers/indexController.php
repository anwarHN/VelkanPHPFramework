<?php
class indexController extends controller{
	function index($args=array()){
		
		$this->setLayout("indexLayout");
		session::_set("times", ((int)session::_get("times"))+1);
		$args["saludo"]="Tiempos: ".session::_get("times");
		
		$this->model->getDataGrid($args);
		/*$args["dataGrid"]=$this->model->dataGrid;*/
		$this->render->view("index", $args);
	}
}
?>