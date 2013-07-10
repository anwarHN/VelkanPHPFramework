<?php
return array(
		"adapter"=>"mysql",
		"user"=>"velkan",
		"pass"=>"velkan123",
		"host"=>"localhost",
		"database"=>"velkan",
		
		/*Estos formatos los aplicará el framework cuando se hagan los querys*/
		"dateFormatForDisplay"=>"%d/%m/%Y",
		"timeFormatForDisplay"=>"%h:%i %p",
		"dateTimeFormatForDisplay"=>"%d/%m/%Y %h:%i %p",
		
		/*Este parametro aplica para bases de datos como oracle que hay que hacerle la funcion to_date() a los campo fecha*/
		"dateFormatForSaving"=>"",
		"timeFormatForSaving"=>"",
		"dateTimeFormatForSaving"=>"",
		
		"dateFormatForQuery"=>"",
		"timeFormatForQuery"=>"",
		"dateTimeFormatForQuery"=>"",
		
		"time_zone"=>"America/Tegucigalpa",
		/*Esta variable es para obtener los dias y meses con sus respectivos nombres en nuestro
		 * idioma
		 * 
		 * @see http://dev.mysql.com/doc/refman/5.0/en/locale-support.html*/
		"localeTimeNames"=>"es_HN",
		"localeTimeCharset"=>"utf8"
		);
?>