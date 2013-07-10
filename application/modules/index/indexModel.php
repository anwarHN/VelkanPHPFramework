<?php
class indexModel extends model{
	public $dataGrid;
	
	function getDataGrid($args=array()){
		/*Extraemos los argumentos en variables*/
		extract($args);
		/*Si el argumento $page no viene declarado, dejamos por defecto que página a mostrar sea la primera*/
		if(!isset($page)){
			$page=1;
		}
		
		/*Declaramos el tipo del objeto*/
		$this->dataGrid=new datagrid(array("id"=>"prueba","title"=>"Prueba de grid"));
		
		/*Seteamos si permitiremos filtros o no en las columnas*/
		$this->dataGrid->allowFilters(true);
		$this->dataGrid->showFilters(true);
		
		/*Seteamos si el grid sera llenado por Ajax. 
		 * Esto ejecutará una funcion dentro del modelo que se debe declarar y cuyo nombre
		 * debe ser el id que se definió anteriormente mas las palabras 'DataGridCallback'*/
		//$this->dataGrid->allowAjaxCall(true);
		
		/*Setea los campos del grid*/
		$this->dataGrid->setFields("id,txt_desc,fecha,numero,porcentaje");
		/*Setea los tipos de cada campo en el orden que se declararon anteriormente*/
		$this->dataGrid->setTypes("number,string,date,number,number");
		/*Vinculoa una accion a una de las columnas, en este caso un hipervinculo*/
		$this->dataGrid->bindFieldTypeParameter("id", "link", "?c=admin/dhdh&other=#fecha#&other2=#porcentaje#");
		$this->dataGrid->bindFieldTypeParameter("porcentaje", "progressbar","");
		/*Setea que el grid debe buscar los datos en la base de datos*/
		$this->dataGrid->getFromDataBase("grid_test",$page,"","ID, Nombre, Fecha, N&uacute;mero,Porcentaje",$filter,$order);
	}
	
	/*Funcion que se ejecutará cuando haya un llamado Ajax*/
	function pruebaDataGridCallBack($args=array()){
		extract($args);
		
		/*Declaramos el tipo del objeto*/
		$dataGrid=new datagrid(array("id"=>"prueba"));
		
		$dataGrid->setFields("id,txt_desc,fecha,numero,porcentaje");
		
		$dataGrid->setTypes("number,string,date,number,progressbar");
		
		$dataGrid->bindFieldTypeParameter("id", "link", "?c=admin/dhdh&other=#fecha#&other2=#porcentaje#");
		$dataGrid->bindFieldTypeParameter("porcentaje", "progressbar","");
		
		/*Obtenemos los datos. El objeto detectará que el llamado actual es un llamado Ajax, y devolverá sólamente los datos,
		 * sin el resto del código DOM*/
		$dataGrid->getFromDataBase("grid_test",$page,"","ID, Nombre, Fecha, N&uacute;mero,Porcentaje",$filter,$order);
		$dataGrid->render();
	}
}
?>