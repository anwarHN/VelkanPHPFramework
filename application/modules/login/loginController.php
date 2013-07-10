<?php
class loginController extends controller{
	
	function index(array $args=null){
		if(isset($args["noLogin"])){
			$args["err"]="No ingreso un usuario o contrase&ntilde;a correcta";
		}
		$this->setLayout("indexLayout");
		$this->render->view("login", $args);
	}
	
	function login(array $args){
		extract($args);
		print_r($args);
		//$this->model->login($user,$pass);
	}
	
	function success(){
		$this->render->view("success", "");
	}
}
?>