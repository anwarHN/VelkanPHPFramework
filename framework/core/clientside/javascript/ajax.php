<?php
/**
 * Velkan PHP Framework
 * Clase para manejos generales de JavaScript
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 */
class ajax{
	/**
	 * $(document).ready() funciton de jQuery
	 * */
	private $js_onLoad;
	
	/**
	 * $(document).ready() funciton de jQuery
	 * */
	function add_js_onload($js){
		$this->js_onLoad.=$js;
	}
	
	/**Returns the content of $(document).ready() funciton of jQuery*/
	function get_js_onload(){
		return $this->js_onLoad;
	}

	/**Global control of js functions*/
	private $js_str="";

	/**Add a javascript function*/
	function add_js_script($js){
		$this->js_str.=$js;
	}
	
	/**Gets the javascript functions added to the object*/
	function get_js_script(){
		$js_script=$this->js_str;
			
		return $js_script;
	}
	
	/**Add a Ajax event to the control
	 * Event supported http://api.jquery.com/category/events/
	* Parameters are given as an array
	*
	* @param boolean async
	* @param string type
	* @param string event
	* @param string php function
	* @param array params(id of every field)
	* @param string dataType
	* @param string url
	* @param string success*/
	function set_js_ajax_event($args){
		if($args["type"]==""){
			$args["type"]="POST";
		}
		if($args["dataType"]==""){
			$args["dataType"]="text";
		}
		if($args["async"]==""){
			$args["async"]="true";
		}
		array_push($this->js_ajax_event, $args);
	}
	
	protected function render_ajax_event($id){
		$ajax="";
		
		foreach ($this->js_ajax_event as $js){
			$ajax.="$(\"#{$id}\").{$js["event"]}(function (){"
			."$.ajax({"
					."type:\"{$js["type"]}\","
					."async:{$js["async"]},"
					."url:\"{$js["url"]}\","
					."data:\"{$js["data"]}\","
					."dataType:\"{$js["dataType"]}\","
							."success:function(data){"
								."{$js["success"]}"
										."},"
										."error:function(err){"
								."alert(err);"
							."}"
										."});});";
		}
		return $ajax;
	}


	/**
	* Collection of jquery.form validations
	* @var array
	*/
	protected $js_validation=array();
	
	/**
	* Add a jQuery.form validation
	* Usage: add_js_validation(array("validation","value","message"));
	*
	* @param array $args
	*/
	function add_js_validation(array $args){
		if(!key_exists("message", $args)||$args["message"]==""){
			$msj=velkan::$lang["err_msg"];
			$val=$args["validation"];
			if(key_exists($val,$msj)){
				$args["message"]=(string)$msj[$val];
			}
		}
		
		$this->js_validation[count($this->js_validation)]= $args;
	}
	
	/**
	 * Propiedad javascript que se ejecutará al hacer click en el boton
	 * @var string
	 */
	protected $onClick="";
	
	/**
	 * Define el evento onClick del objeto
	 * @param string $js Código javascript a ejecutar
	 */
	public function setOnClick($js){
		$this->onClick=$js;
	}
	
	/**
	 * Renderiza los eventos javascript que tengamos
	 */
	protected final function checkEvents($id){
		if($this->onClick!==""){
			page::addJavaScriptOnLoad("$('#$id').bind('click',function(){".$this->onClick."});");
		}
	}
}
?>