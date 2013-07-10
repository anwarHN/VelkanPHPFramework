<?php
class controlsController extends controller{
	
	function index(array $args=null){
		$this->setLayout("indexLayout");
		$this->render->view("controls", $args);
	}
}
?>