<?php
class formExampleController extends controller{
	function index($args=array()){
		$this->setLayout("indexLayout");
		$this->render->view("formExample", $args);
	}
	
	function guardar($args=array()){
		if($this->model->save()){
			$formArgs["formAlertType"]=form::$FORM_ALERT_TYPE_SAVING_OK;
		}else{
			$formArgs["formAlertType"]=form::$FORM_ALERT_TYPE_SAVING_NOTOK;
			
			//Se puede enviar el mensaje personalizado
			$formArgs["alertMessage"]=$this->model->getError();
		}
		
		velkan::redirect("formExample/",$formArgs);
	}
}
?>