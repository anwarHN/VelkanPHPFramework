<?php
class actionsExampleController extends controller{
	function index($args=array()){
		$this->setLayout("indexLayout");
		$this->model->getGrid($args);
		$this->render->view("actionsExample",$args);
	}
	
	function ver($args=array()){
		$this->setLayout("indexLayout");
		$this->getModel("actions");
		
		$id=$args["methodParams"][0];
		
		if($id){
			//Si los datos no se encuentran, renderizamos un error.
			if($this->model->getById(array(array("field"=>"id","type"=>velkan::$DATATYPE_NUMBER,"value"=>$id)))){
				$this->model->setReadOnly(true);
				$this->render->view("actions");
			}else{
				$this->render->error(velkan::$ERROR_TYPE_NO_DATA_FOUND);
			}
		}
	}
	
	function nuevo($ags=array()){
		$this->setLayout("indexLayout");
		$this->getModel("actions");
		$this->render->view("actions");
	}
	
	function modificar($args=array()){
		$this->setLayout("indexLayout");
		$this->getModel("actions");
		
		$id=$args["methodParams"][0];
		
		if($id){
			//Si los datos no se encuentran, renderizamos un error.
			if($this->model->getById(array(array("field"=>"id","type"=>velkan::$DATATYPE_NUMBER,"value"=>$id)))){
				$this->render->view("actions");
			}else{
				$this->render->error(velkan::$ERROR_TYPE_NO_DATA_FOUND);
			}
		}
	}
	
	function guardar($args=array()){
		$this->getModel("actions");
		
		if($this->model->save()){
			$formArgs["formAlertType"]=form::$FORM_ALERT_TYPE_SAVING_OK;
		}else{
			$formArgs["formAlertType"]=form::$FORM_ALERT_TYPE_SAVING_NOTOK;
			//Se puede enviar el mensaje personalizado
			$formArgs["alertMessage"]=$this->model->getError();
		}
		//echo $this->model->getError();
		
		velkan::redirect("actionsExample/",$formArgs);
	}
	
	function eliminar($args=array()){
		$this->getModel("actions");
		
		$id=$args["methodParams"][0];
		
		if($id){
			//Si los datos no se encuentran, renderizamos un error.
			if($this->model->delete(array(array("field"=>"id","type"=>velkan::$DATATYPE_NUMBER,"value"=>$id)))){
				$formArgs["formAlertType"]=form::$FORM_ALERT_TYPE_NORMAL;
				$formArgs["alertMessage"]="Se elimino el registro correctamente.";
			}else{
				$formArgs["formAlertType"]=form::$FORM_ALERT_TYPE_ERROR;
				$formArgs["alertMessage"]=$this->model->getError();
			}
			
			velkan::redirect("actionsExample/",$formArgs);
		}else{
			velkan::redirect("actionsExample/");
		}
	}
}