<?php
class formularioAjaxController extends controller{
	function index($args=array()){
		$this->setLayout("indexLayout");
		$this->render->view("formularioAjax",$args);
	}
}
?>