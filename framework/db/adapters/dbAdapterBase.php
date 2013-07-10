<?php
/**
 * Velkan PHP Framework
 * Interface db
 * De esta interface se deben implementar los adaptadores
 *
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
interface dbAdapterBase{
	
	/**
	 * Conecta a la base de datos
	 */
	function connect();
	/**
	 * Cierra la conexion a la base de datos
	 */
	function close();
	/**
	 * Comienza una transaccion
	 */
	function begin();
	/**
	 * Hace commit a una transaccion iniciada con begin()
	 */
	function commit();
	/**
	 * Deshace todos los cambios que se hicieron con begin()
	 */
	function rollback();
	/**
	 * Hace un query a la base de datos que debe devolver un resultado de filas
	 * @param string $sql
	 */
	function query($sql,$calculateRows=false,$fastHint=false);
	/**
	 * Ejecuta un comando en la base de datos que no devolvera un resultado
	 * @param string $sql
	 */
	function exec($sql);
	/**
	 * Hace un fetch a un arreglo, fila por fila, de todos los datos que se hayan obtenido con query()
	 */
	function fetch();
	/**
	 * Obtiene un array con todos los datos que se hayan obtenido con query()
	 */
	function getArray();
	/**
	 * Libera el recurso utilizacon por query()
	 */
	function freeResult();
	/**
	 * Hace un scape a posibles valores para evitar ataques de sqlinjection
	 * @param $value
	 */
	function checkRealEscapeString($value);
	/**
	 * Obtiene el último id insertado en una tabla que tenga un campo autoincrement
	 */
	function getLastInsertedID();
	
	/**
	 * Devuelve un result de una tabla
	 * 
	 * @param string $table
	 * @param string $field
	 * @param string $value
	 */
	function getByID($table,$field,$value);
	
	/**
	 * Devuelve un result de una tabla con los campos especificados
	 * 
	 * @param string $table
	 * @param string $fields
	 * @param string $condition
	 */
	function getFields($table,$fields="",$condition="",$limit="",$calculateRows=false,$fastHint=false);
	
	/**
	 * Inserta registros en una tabla
	 * 
	 * @param string $table Tabla donde se insertarán los registros
	 * @param array $data Arreglo de informacion a insertar. Cada llave del arreglo se interpreta como campo de la base de datos
	 * 
	 * @example $table="tabla"; $data=array("campo1"=>"valor1","campo2"=>"valor2"); db::insert($table,$data);
	 */
	function insert($table,array $data);
	
	/**
	 * Actualiza registros en una tabla
	 * 
	 * @param string $table Nombre de la tabla donde se hará el update
	 * @param array $updates Arreglo de updates. Cada llave del arreglo será cada campo
	 * @param Mixed $conditions Puede ser un arreglo o las condiciones declaradas explicitamente
	 * 
	 * @example $table="tabla"; $updates=array("campo1"=>array("value"=>"valor1","type"=>"string"),"campo2"=>array("value"=>"valor2","type"=>"number")); $conditions=array("campo1"=>"condicion1","campo2"=>"condicion2"); db::update($table,$updates,$conditions);
	 * @example $table="tabla"; $updates=array("campo1"=>array("value"=>"valor1","type"=>"string"),"campo2"=>array("value"=>"valor2","type"=>"number")); $conditions="id=1 AND id2=2"; db::update($table,$updates,$conditions);
	 */
	function update($table,array $updates,$conditions);
	
	/**
	 * Elimina registros de una tabla
	 * 
	 * @param string $table
	 * @param array $conditions
	 */
	function delete($table, array $conditions);
	
	/**
	 * Setea una nueva conexion, sobreescribiendo la que esta por defecto
	 */
	function setDatabaseConnection($host,$database,$user,$pass);
	
	/**
	 * Obtiene el número de columnas del query ejecutado
	 */
	function getNumCols();
	
	/**
	 * Obtiene el número de filas retornadas en el query ejecutado
	 */
	function getNumRows();
	
	/**
	 * Indica el tipo de fetch que hará el adaptador. MySql tiene varios tipos de fetch. 
	 */
	function setFetchType($type);
	
	
	/**
	 * Obtiene recuento de todas las filas afectadas en un query sin importar los limits
	 */
	function getCalculatedRows();
	
	/**
	 * Devuelve el error que haya generado un comando a la base de datos
	 */
	function getError();
	
	/**
	 * Formatea un campo tipo date para que devuelva el formato deseado por el usuario
	 * @param string $field Nombre del campo a formatear
	 * @filesource framework/config/dbConfig.php Ver el parámetro "dateFormatForDisplay"=>""
	 */
	function formatDateForDisplay($field);
	
	/**
	 * Formatea un campo tipo time para que devuelva el formato deseado por el usuario
	 * @param string $field Nombre del campo a formatear
	 * @filesource framework/config/dbConfig.php Ver el parámetro "timeFormatForDisplay"=>""
	 */
	function formatTimeForDisplay($field);
	
	/**
	 * Formatea un campo tipo date_time para que devuelva el formato deseado por el usuario
	 * @param string $field Nombre del campo a formatear
	 * @filesource framework/config/dbConfig.php Ver el parámetro "dateTimeFormatForDisplay"=>""
	 */
	function formatDateTimeForDisplay($field);
	
	/**
	 * Formatea un valor para poder hacer comparaciones contra campos tipo date en la base de datos de forma correcta
	 * @param string $date Valor tipo date a formatear
	 * @filesource framework/config/dbConfig.php Ver el parámetro "dateFormatForQuery"=>""
	 */
	function formatDateValueForQuery($date);
	
	/**
	 * Formatea un valor para poder hacer comparaciones contra campos tipo time en la base de datos de forma correcta
	 * @param string $time Valor tipo date a formatear
	 * @filesource framework/config/dbConfig.php Ver el parámetro "timeFormatForQuery"=>""
	 */
	function formatTimeValueForQuery($time);
	
	/**
	 * Formatea un valor para poder hacer comparaciones contra campos tipo date_time en la base de datos de forma correcta
	 * @param string $dateTime Valor tipo date a formatear
	 * @filesource framework/config/dbConfig.php Ver el parámetro "dateTimeFormatForQuery"=>""
	 */
	function formatDateTimeValueForQuery($dateTime);
	
	/**
	 * Formatea un valor para poder guardarlo en la base de datos en un campo tipo date
	 * @param string $date Valor a formatear
	 * @filesource framework/config/dbConfig.php Ver el parámetro "dateFormatForSaving"=>""
	 */
	function formatDateValueForSaving($date);
	
	/**
	 * Formatea un valor para poder guardarlo en la base de datos en un campo tipo time
	 * @param string $time Valor a formatear
	 * @filesource framework/config/dbConfig.php Ver el parámetro "timeFormatForSaving"=>""
	 */
	function formatTimeValueForSaving($time);
	
	/**
	 * Formatea un valor para poder guardarlo en la base de datos en un campo tipo date_time
	 * @param string $dateTime Valor a formatear
	 * @filesource framework/config/dbConfig.php Ver el parámetro "dateTimeFormatForSaving"=>""
	 */
	function formatDateTimeValueForSaving($dateTime);
}
?>