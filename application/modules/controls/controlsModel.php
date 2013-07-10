<?php
	class controlsModel extends model{
		public $combo1;
		public $combo2;
		public $combo3;
		public $texta;
		public $checkbox;
		public $radio;
		public $input3;
		
		function load($args=array()){
			$this->combo1=new select(array("id"=>"usu"));
			$this->combo1->setPromt("[Seleccione un valor]");
			$this->combo1->getFromDataBase("select_test", "id,txt_desc", "", "");
				
			$this->combo2=new select(array("id"=>"usu2"));
			$this->combo2->setDependency("usu","select_test_dependency","id,text","id_parent");
			//$this->combo2->setDependency("usu");
			$this->combo3=new select(array("id"=>"usu3"));
			$this->combo3->setDependency("usu,usu2","select_test_dependency_2","id,text","id_parent_1,id_parent_2");
			//$this->combo3->setDependency("usu,usu2");
				
			$this->texta=new textarea(array("id"=>"textArea1","placeholder"=>"Hola","style"=>"width:615px;height:200px"));
			$this->texta->setWysihtml(true);
				
			$this->checkbox=new checkbox(array("id"=>"check1","label"=>"Prueba checkbox","checkedValue"=>"1","uncheckedValue"=>"0"));
				
			$this->radio=new radiobutton(array("id"=>"radio1"));
			$this->radio->getFromDataBase("option_test","id,text");
			
			$this->input3= new input(array("id"=>"range1","type"=>"range","value"=>"10","attributes"=>array("min"=>"0","max"=>"15")));
		}
		/*
		function usu2DependencyCallback($args){
			extract($args);
			$combo1=new select();
			$combo1->getFromDataBase("select_test_dependency", "id,text", "id_parent=$usu", "");
			$combo1->render();
		}
		
		function usu3DependencyCallback($args){
			extract($args);
			$combo=new select();
			$combo->getFromDataBase("select_test_dependency_2", "id,text","id_parent_1=$usu AND id_parent_2=$usu2");
			$combo->render();
		}
		*/
	}
?>