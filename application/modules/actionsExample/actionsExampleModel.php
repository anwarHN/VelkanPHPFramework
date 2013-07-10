<?php
class actionsExampleModel extends model{
	public $grid1;
	
	function load(){
	
	}
	
	function getGrid($args=array()){
		extract($args);
		
		if(!isset($page)){
			$page=1;
		}
		
		$this->grid1=new datagrid(array("id"=>"grid1"));
		
		$f=jsHelper::callFunction("nuevo");
		
		$html=<<<HTML
			<div style="float:left">Acciones sobre datos</div>
			<div style="float:right">
				<button class="btn" type="button" onclick="$f">Nuevo</button>
			</div>
			<div style="clear:both"></div>
HTML;
		$this->grid1->setTitleTemplate($html);
		
		$this->grid1->setFields("id,text,text_area,date,time,datetime");
		$this->grid1->setTypes("number,string,string,date,time,date_time");
		$this->grid1->getFromDataBase("form_test",$page,"","Id, Texto, Texto grande, Fecha, Hora, Fecha y hora",$filter,$order);
		$this->grid1->appendActionCol("Acciones", array(
														array("class"=>"btn-link","caption"=>"Ver","javascript"=>jsHelper::callFunction("ver/#id#")),
														array("class"=>"btn-link","caption"=>"Modificar","javascript"=>jsHelper::callFunction("modificar/#id#")),
														array("class"=>"btn-link","caption"=>"Eliminar","javascript"=>jsHelper::confirmCallFunction("Eliminar","Est&aacute; seguro de eliminar el registro?", "eliminar/#id#"))
														)
		);
	}
}