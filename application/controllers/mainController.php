<?php
class mainController extends controller{
	function index(){
		$this->render->view("main", $args);
	}
}