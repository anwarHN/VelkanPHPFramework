<?php
class uploadController extends controller{
	function index($args=array()){
		$this->setLayout("indexLayout");
		$this->render->view("upload", $args);
	}
}