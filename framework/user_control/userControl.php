<?php
/**
 * Velkan PHP Framework
 * Control de usuario hijo
 * Clase modificable para el control de usuarios
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 */
class userControl extends userBase{
	function login(){
		$sql = "SELECT 1 valid FROM usuarios WHERE id_txt_usuario = '{$this->user}' AND txt_pass='{$this->pass}'";
		$this->db->connect();
		
		$rs=$this->db->query($sql);
		
		if(!$rs){
			return false;
		}
		
		while($row=$this->db->fetch()) {
			if($row["valid"]=="1"){
				$this->properties["name"]="ANWAR GARCIA";
				$this->setSelfDataBaseConnection("localhost", "velkan", "velkan", "velkan123");
				return true;
			}
		}
	}
	
	function noDataFound(){
		velkan::redirect("logout/");
	}
}
?>