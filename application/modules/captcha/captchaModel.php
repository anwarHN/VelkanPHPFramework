<?php
class captchaModel extends model{
	public $captcha;
	
	public function load($args=array()){
		$this->captcha=new captcha(array("id"=>"captcha1","caption"=>"Prueba","label"=>"Ingrese el c&oacute;digo de verificaci&oacute;n:"));
	}
}