<?php
class dataviewModel extends model{
	public $dataView;
	
	function load(){
		$this->dataView=new dataview(array("id"=>"dataView1"));
		$this->dataView->getFromDataBase("dataview_test");
		$this->dataView->setHtml("<div class='span5'><h1>#header#</h1>#description#</div>");
		$this->dataView->setContainerClass("row");
	}
}