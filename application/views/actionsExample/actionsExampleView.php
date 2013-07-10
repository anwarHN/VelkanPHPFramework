<h1>Ejemplo de acciones con la base de datos</h1>
<?php 

if(isset($formAlertType)){
	velkan::widget("velkan.alert", array("message"=>form::getAlertTypeMessage($formAlertType)."  ".$alertMessage,"class"=>form::getAlertTypeClass($formAlertType)),true);
}

$model->grid1->render();
?>