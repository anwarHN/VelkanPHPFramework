<?php
/**
 * Velkan PHP Framework
* Clase para heredar los atributos globales de html5. Para más informacion vaya a http://www.w3schools.com/tags/ref_standardattributes.asp
*
* LICENCIA: Libre de uso.
*
* @author     Anwar Garcia <garciaanwar@gmail.com>
* @copyright  2012 Anwar Garcia
* @version    v1.0
*/
abstract class globalAttr extends ajax{
	/**
	 * Type string, Specifies a shortcut key to activate/focus an element
	 * */
	protected $accesskey="";
	
	function setAccesskey($accesskey){
		$this->accesskey=$accesskey;
	}
	function getAccesskey(){
		return $this->accesskey;
	}
	
	/**Type string, Specifies one or more classnames for an element (refers to a class in a style sheet)*/
	protected $class="";
	
	/**
	 * Añade una clase al objeto
	 * @param string $class Clase a añadir
	 */
	function addClass($class){
		$this->class.=" $class";
	}
	function getClass(){
		return $this->class;
	}
	
	/**Type string, values "true|false|inherit" Specifies whether the content of an element is editable or not*/
	protected $contenteditable="";

	function setContentEditable($contenteditable){
		if($contenteditable!="true"&&$contenteditable!="flase"&&$contenteditable!="inherit"){
			throw new VException("Error in contenteditable value, use \"true|false|inherit\"");
			return;
		}
		$this->contenteditable=$contenteditable;
	}
	function getContentEditable(){
		return $this->contenteditable;
	}
	
	/**Type string, Specifies a context menu for an element. The context menu appears when a user right-clicks on the element*/
	protected $contextmenu="";

	function setContextMenu($contextmenu){
		$this->contextmenu=$contextmenu;
	}
	function getContextMenu(){
		return $this->contextmenu;
	}
	
	/**Type string, values "ltr|rtl|auto", Specifies the text direction for the content in an element*/
	protected $dir="";
	
	function setDir($dir){
		if($dir!="ltr"&&$dir!="rtl"&&$dir!="auto"){
			throw new Exception("Error in dir value, use \"ltr|rtl|auto\"");
			return;
		}else{
			$this->dir=$dir;
		}
	}
	function getDir(){
		return $this->dir;
	}

	/**Type boolean, Specifies whether an element is draggable or not*/
	protected $draggable=false;
	function setDraggable($draggable){
		$this->draggable=$draggable;
	}
	function getDraggable(){
		return $this->draggable;
	}

	/**Specifies whether the dragged data is copied, moved, or linked, when dropped*/
	protected $dropzone="";
	function setDropzone($dropzone){
		$this->dropzone=$dropzone;
	}
	function getDropzone(){
		return $this->dropzone;
	}
	/**Type boolean, Specifies that an element is not yet, or is no longer, relevant*/
	protected $hidden=false;
	function setHidden($hidden){
		$this->hidden=$hidden;
	}
	function getHidden(){
		return $this->hidden;
	}
	/**Type string, Specifies a unique id for an element*/
	protected $id="";
	function setId($id){
		$this->id=$id;
	}
	function getId(){
		return $this->id;
	}
	/**Type string, Specifies the language of the element's content. Go to http://www.w3schools.com/tags/ref_language_codes.asp for a list of language code*/
	protected $lang="";
	function setLang($lang){
		$this->lang=$lang;
	}
	function getLang(){
		return $this->lang;
	}


	/**Type string, values "true|false", Specifies whether the element is to have its spelling and grammar checked or not*/
	protected $spellcheck="";
	function setSpellcheck($spellcheck){
		$this->spellcheck=$spellcheck;
	}
	function getSpellcheck(){
		return $this->spellcheck;
	}
	/**Type string, Specifies an inline CSS style for an element*/
	protected $style="";
	function setStyle($style){
		$this->style=$style;
	}
	function getStyle(){
		return $this->style;
	}

	/**Type number, Specifies the tabbing order of an element*/
	protected $tabindex;
	function setTabIndex($tabindex){
		$this->tabindex=$tabindex;
	}
	function getTabIndex(){
		return $this->tabindex;
	}

	/**
	 * Titulo de un objeto
	 * @var string
	 */
	protected $title="";
	
	/**
	 * Setea el titulo de un objeto
	 * @param string $title
	 */
	function setTitle($title){
		$this->title=$title;
	}
	/**Type string, Gets extra information about an element*/
	function getTitle(){
		return $this->title;
	}
	
	function assingVars($args){
		
		if(!isset($args["id"])){
			$e=new VException("No se especificó el valor de id");
			$e->process();
		}
		
		$this->accesskey=$args["accesskey"];
		$this->id=$args["id"];
		$this->class=$args["class"];
		$this->contenteditable=$args["contenteditable"];
		$this->contextmenu=$args["contextmenu"];
		$this->dir=$args["dir"];
		$this->draggable=$args["draggable"];
		$this->dropzone=$args["dropzone"];
		$this->hidden=$args["hidden"];
		$this->lang=$args["lang"];
		$this->spellcheck=$args["spellcheck"];
		$this->style=$args["style"];
		$this->tabindex=$args["tabindex"];
		$this->title=$args["title"];
		
		if(isset($args["dataField"])){
			$this->dataField=$args["dataField"];
		}else{
			$this->dataField=$args["id"];
		}
	}
	
	/**
	 * Atributos adicionales para los controles
	 * @var array
	 */
	protected $attribs=array();
	
	/**
	 * Agrega atributos de usuario o especiales al control
	 * @param array $attribs
	 * @example $control->addAttributes(array("max"=>"100","min"=>"0"));
	 */
	public function addAttributes(array $attribs){
		$this->attribs=$attribs;
	}
}
?>