<?php
class selectorsController extends controller{
	function index($args=array()){
		$this->setLayout("indexLayout");
		$this->render->view("selectors", $args);
	}
}