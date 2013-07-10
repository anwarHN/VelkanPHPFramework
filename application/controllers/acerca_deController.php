<?php
class acerca_deController extends controller{
	function index(){
		$this->setLayout("indexLayout");
		$this->render->view("acerca_de", array());
	}
}
?>