<?php
/**
 * Velkan PHP Framework
 * Clase Load
 * Desde aqui se cargaran las vistas y los modelos
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 * @see https://github.com/Jontyy/PHP-Basic-MVC-Framework
 * @see http://www.youtube.com/watch?v=O3ogaH5AOOw
 */
class load{

	public function view($name,array $vars = null){
		$file = SITE_PATH.'views/'.$name.'View.php';

		if(is_readable($file)){

			if(isset($vars)){
				extract($vars);
			}
			require($file);
			return true;
		}
		throw new Exception('View issues');
	}
	public function model($name){
		$model = $name.'Model';
		$modelPath = SITE_PATH.'models/'.$model.'.php';

		if(is_readable($modelPath)){
			require_once($modelPath);

			if(class_exists($model)){
				$registry = Registry::getInstance();
				$registry->$name = new $model;
				return true;
			}
		}
		throw new Exception('Model issues.');
	}
}
?>