<?php
class dataviewController extends controller{
	function index($args=array()){
		$this->setLayout("indexLayout");
		$this->render->view("dataview");
	}
}