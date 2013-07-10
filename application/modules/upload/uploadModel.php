<?php
class uploadModel extends model{
	public $upload;
	
	function load(){
		$this->upload=new file(array("id"=>"upload1","multiple"=>true));
		//$this->upload->setUploadAtOnce(true);
		$this->upload->setAllowedFileExtensions("jpg,jpeg,mp3,wmv,png");
		$this->upload->setChangeUploadFileName(false);
	}
	
	function upload1CallBack($args,$fileParams){
		extract($fileParams);
		echo "File path: '".$fileDir."'".PHP_EOL;
		echo "File name: '".$fileName."'".PHP_EOL;
		echo "File fisical name: '".$fisicalName."'".PHP_EOL;
	}
}