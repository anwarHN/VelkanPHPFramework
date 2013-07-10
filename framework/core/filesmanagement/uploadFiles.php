<?php
/**
 * Velkan file uploader
 * Archivo generico para subir archivos desde el navegador del cliente
 */



debugLogger::log("uploadFiles", $args);
debugLogger::log("uploadFiles", "============================");
debugLogger::log("uploadFiles", date('l jS \of F Y h:i:s A'));
debugLogger::log("uploadFiles", "============================");

$registry=registry::getInstance();
$input=$registry->args["__THEINPUTNAME__"];

//Para saber el tiempo de carga
list($Mili, $bot) = explode(" ", microtime());
$DM=substr(strval($Mili),2,4);

//Para cambiar posteriormente el nombre del archivo
$id=session::_getId()."_".strval(date("Y").date("m").date("d").date("H").date("i").date("s") . $DM);



$newfiles = array();
foreach($_FILES as $fieldname => $fieldvalue)
	foreach($fieldvalue as $paramname => $paramvalue)
	foreach((array)$paramvalue as $index => $value)
	$newfiles[$fieldname][$index][$paramname] = $value;

//Buscamos el arreglo de archivos a subir
foreach($newfiles[$input] as $file){
	debugLogger::log("uploadFiles", "Param: '$input'");
	debugLogger::log("uploadFiles", "File name: '{$file["name"]}'");
	debugLogger::log("uploadFiles", "File temp name: '{$file["tmp_name"]}'");
	
	$nombre_archivo = $file['name'];
	$directorio_base= velkan::$config["file"]["uploadDir"]."/";
	$directorio_definitivo = velkan::$config["file"]["uploadDir"]."/$nombre_archivo";
	$directorio_definitivo2 = velkan::$config["file"]["uploadDir"]."/$id";
	
	debugLogger::log("uploadFiles", "Upload dir: '$directorio_definitivo'");
	
	if(is_uploaded_file($file['tmp_name'])){
		if($registry->args["changeFileName"]=="true"){
			@move_uploaded_file($file['tmp_name'], $directorio_definitivo2);
		}else{
			@move_uploaded_file($file['tmp_name'], $directorio_definitivo);
		}
	}
}

$obj=array($model,$registry->args["fu"]);
unset($registry->args["fu"]);

call_user_func_array($obj,array($request->getArgs(),array("fileDir"=>$directorio_base,"fileName"=>$nombre_archivo,"fisicalName"=>$id)));
?>