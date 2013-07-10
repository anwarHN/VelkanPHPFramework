<?php
	class loginModel extends model{
		
		public $input1;
		public $input2;
		public $form;
		
		function load(){
			$this->input1= new input(array("id"=>"user","placeholder"=>"Usuario","type"=>"text"));
			$this->input2= new input(array("id"=>"pass","placeholder"=>"Contrase&ntilde;a","type"=>"password"));
			
			$this->form= new form(array("id"=>"formaLogin","method"=>"post","function"=>"login"));
			$this->form->addRule("required", "true","", "user,pass");
		}
		
		function login($user, $pass){
			if(user::login($user, $pass)){
				velkan::redirect("main/");
			}else{
				velkan::redirect("login/",array("noLogin"=>"true"));
			}
		}
	}
?>