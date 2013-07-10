<?php
class buttonController extends controller{
	public function index($args=array()){
		$this->setLayout("indexLayout");
		$this->render->view("button", $args);
	}
}