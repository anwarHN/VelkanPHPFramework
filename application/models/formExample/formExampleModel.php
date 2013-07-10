<?php
class formExampleModel extends model{
	public $id;
	public $text;
	public $textArea;
	public $date;
	public $dateTime;
	public $time;
	public $select;
	public $selectD;
	public $selectD2;
	public $selectD3;
	public $option;
	public $checkbox;
	public $button;
	
	function load(){
		$this->id=new input(array("id"=>"id","readonly"=>true,"dataField"=>"id"));
		$this->text=new input(array("id"=>"text", "dataField"=>"text"));
		$this->textArea=new textarea(array("id"=>"textArea","dataField"=>"text_area"));
		$this->date=new date_time(array("id"=>"dateInput","dataField"=>"date","pickerType"=>date_time::$DATETIME_PICKER_TYPE_DATE));
		
		$this->dateTime=new date_time(array("id"=>"dateTimeInput","dataField"=>"datetime","pickerType"=>date_time::$DATETIME_PICKER_TYPE_DATETIME));
		
		$this->time=new date_time(array("id"=>"timeInput","dataField"=>"time","pickerType"=>date_time::$DATETIME_PICKER_TYPE_TIME));
		
		$this->select=new select(array("id"=>"select","dataField"=>"select"));
		$this->select->addItem("1", "Prueba 1");
		$this->select->addItem("1", "Prueba 2");
		
		$this->selectD=new select(array("id"=>"selectD","dataField"=>"select_dependency_1"));
		$this->selectD->setPromt("[Seleccione un valor]");
		$this->selectD->getFromDataBase("select_test", "id,txt_desc");
		
		$this->selectD2=new select(array("id"=>"selectD2","dataField"=>"select_dependency_2"));
		$this->selectD2->setDependency("selectD","select_test_dependency","id,text","id_parent");
		
		$this->selectD3=new select(array("id"=>"selectD3","dataField"=>"select_dependency_3"));
		$this->selectD3->setDependency("selectD,selectD2","select_test_dependency_2","id,text","id_parent_1,id_parent_2");
		
		$this->option=new radiobutton(array("id"=>"radioButon","dataField"=>"option"));
		$this->option->setOptionButtons(array("Opcion 1"=>1,"Opcion 2"=>2));
		
		$this->checkbox=new checkbox(array("id"=>"checkbox","checkedValue"=>"1","uncheckedValue"=>"2","label"=>"Checkbox","dataField"=>"checkbox"));
		
		$this->button=new button(array("id"=>"button1","type"=>"submit","caption"=>"Guardar"));
		
		$this->setDBObject("form_test", model::$DBOBJECT_TYPE_TABLE);
		$this->setTablePrimaryKey("id");
	}
	
	function setRules(){
		$this->rules=array("forma1"=>array(
												array("required","true","", "textArea,text"),
												array("maxlength","10","","textArea")
											)
					);
	}
}
?>