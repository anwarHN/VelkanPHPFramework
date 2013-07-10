<?php
	class loginModel extends model{
		
		public $input1;
		public $input2;
		
		function load(){
			$this->input1= new input(array("id"=>"user","placeholder"=>"Usuario","type"=>"text"));
			$this->input2= new input(array("id"=>"pass","placeholder"=>"Contrase&ntilde;a","type"=>"password"));
		}
		
		function login($user, $pass){
			if(user::login($user, $pass)){
				velkan::redirect("main/");
			}else{
				velkan::redirect("login/",array("noLogin"=>"true"));
			}
		}
		
		function setRules(){
			$this->rules=array("forma1"=>array(
												array("required","true","", "user,pass"),
												array("maxlength","150","","user")
											)
					);
		}
		
		function setFormats(){
			$this->formats=array(array("string","user"));
		}
	}
?>