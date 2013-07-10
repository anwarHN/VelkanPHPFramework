<?php
class formularioAjaxModel extends model{
	public $inputId;
	public $textAreaText;
	public $formAjax;
	
	function load($args=array()){
		$this->inputId=new input(array("id"=>"inputId","disabled"=>true,"dataField"=>"id"));
		$this->textAreaText=new textarea(array("id"=>"textAreaText","style"=>"width:615px;height:200px","dataField"=>"text"));
		//$this->textAreaText->setWysihtml(true);
		
		$this->formAjax=new form(array("id"=>"formAjax","method"=>"post","function"=>"guardar","class"=>"form-horizontal","ajaxForm"=>true));
		$this->formAjax->addRule("required","true", "textAreaText");
	}
	
	//Funcion que ejecutará el formulario ajax
	function guardar(array $args){
		$this->dbObjectName="form_test";
		$this->dbObjectType=model::$DBOBJECT_TYPE_TABLE;
		if($this->save()){
			$this->formAjax->jsHelper(form::$FORM_JSHELPER_SENDALERT, array("alertType"=>form::$FORM_ALERT_TYPE_SAVING_OK,"alertMessage"=>""));
		}else{
			$this->formAjax->jsHelper(form::$FORM_JSHELPER_SENDALERT, array("alertType"=>form::$FORM_ALERT_TYPE_SAVING_NOTOK,"alertMessage"=>$this->dbError));
		}
	}
}
?>