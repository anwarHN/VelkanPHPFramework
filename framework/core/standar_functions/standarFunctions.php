<?php
/**
 * Velkan PHP Framework
 * Funciones estandar para Ajax
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 */
class standar_ajax_functions{
	var $functions=array();
	var $definitions=array();
	
	function __construct(){
		$this->functions=array("validateSession","applyFormats","generalFunctions");
		$this->definitions=array(
								"validateSession"=>"$.ajax({
															type:'POST',
															data:'sf=validateSession'
															}).done(function(msg){
																				alert(msg);
																				if(msg==\"false\"){
																					window.location='?c=logout/';
																				}
															});;",
								"applyFormats"=>$this->applyFormats(),
								"generalFunctions"=>$this->generalFunctions()
								);
	}
	function isValid($function){
		if(in_array($function, $this->functions)){
			return true;
		}else{
			return false;
		}
	}
	
	function validateSession(){
		if(!session::_sessionStarted()){
			session::_beginSession();
		}
		if(session::_validateLifeTime()&&user::_isDataInitialized()){
			echo "true";
		}else{
			echo "false";
		}
	}
	
	function getDefinition($function){
		if(key_exists($function, $this->definitions)){
			return $this->definitions[$function];
		}
	}
	
	function applyFormats(){
		
		
		
		$function= "$('input[number]').bind('keypress',function(event){";
		$function.="if((event.which<48||event.which>57)&&event.which!=46&&event.which!=45&&event.which!=8&&event.which!=0&&event.which!= 13){";
		$function.="event.preventDefault();lastKeypressPrevented=$(this).attr('id');";
		$function.="}else{lastKeypressPrevented='';}";
		$function.="});";
		$function.="$('input[number_unsigned]').bind('keypress',function(event){";
		$function.="if((event.which<48||event.which>57)&&event.which!=46&&event.which!=8&& event.which!=0&&event.which!=13){";
		$function.="event.preventDefault();lastKeypressPrevented=$(this).attr('id');";
		$function.="}else{lastKeypressPrevented='';}";
		$function.="});";
		$function.="$('input[uppercase]:not([type=\"email\"])').bind('blur',function(){";
		$function.="$(this).val($(this).val().toUpperCase());";
		$function.="}";
		$function.=");";
		$function.="$('textarea[uppercase]').bind('blur',function(){";
		$function.="$(this).val($(this).val().toUpperCase());";
		$function.="});";
		
		
		return $function;
	}
	
	function addAttrib($id,$attrib,$value){
		return "$('#$id').attr('$attrib','$value');";
	}
	
	function generalFunctions(){
		$registry=registry::getInstance();
		
		$function="function redirect(c,f){window.location='?c='+c+'/'+f;}".PHP_EOL;
		$function.="function callFunc(f){window.location='?c=".$registry->controllerName."/'+f;}".PHP_EOL;
		
		return $function;
	}
}
?>