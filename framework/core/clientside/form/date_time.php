<?php
/**
 * Velkan PHP Framework
 * Date Time control - Coleccion de propiedades para renderizar inputs con el plugin datetimepicker para bootstrap
 *
 * LICENCIA: Libre de uso.
 * 
 * Formatos aceptados:
 * p : meridian in lower case ('am' or 'pm') - according to locale file
 * P : meridian in upper case ('AM' or 'PM') - according to locale file
 * s : seconds without leading zeros
 * ss : seconds, 2 digits with leading zeros
 * i : minutes without leading zeros
 * ii : minutes, 2 digits with leading zeros
 * h : hour without leading zeros - 24-hour format
 * hh : hour, 2 digits with leading zeros - 24-hour format
 * H : hour without leading zeros - 12-hour format
 * HH : hour, 2 digits with leading zeros - 12-hour format
 * d : day of the month without leading zeros
 * dd : day of the month, 2 digits with leading zeros
 * m : numeric representation of month without leading zeros
 * mm : numeric representation of the month, 2 digits with leading zeros
 * M : short textual representation of a month, three letters
 * MM : full textual representation of a month, such as January or March
 * yy : two digit representation of a year
 * yyyy : full numeric representation of a year, 4 digits
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 * @see http://www.malot.fr/bootstrap-datetimepicker
 */
class date_time extends globalAttr{
	/**
	 * Nombre del campo de base de datos
	 * @var string
	 */
	protected $dataField;
	
	/**
	 * Setea el nombre del campo de la base de datos
	 * @param string $dataField
	 */
	function setDataField($dataField){
		$this->dataField=$dataField;
	}
	
	/**
	 * Obtiene el valor del nombre del campo asignado en la base de datos
	 * @return string
	 */
	function getDataField(){
		return $this->dataField;
	}
	
	/**
	 * Tipo de dato que almacenará el objeto
	 * @var string
	 */
	protected $dataType="";
	
	function getDataType(){
		return $this->dataType;
	}
	
	/**
	 * Setea el tipo de dato del objeto
	 */
	private function setDataType(){
		switch ($this->pickerType) {
			case self::$DATETIME_PICKER_TYPE_DATETIME:
				$this->dataType=velkan::$DATATYPE_DATETIME;
			break;
			
			case self::$DATETIME_PICKER_TYPE_DATE:
				$this->dataType=velkan::$DATATYPE_DATE;
				break;
			case self::$DATETIME_PICKER_TYPE_TIME:
				$this->dataType=velkan::$DATATYPE_TIME;
				break;
			default:
				$this->dataType="";
			break;
		}
	}
	
	/**
	 * Nombre del control
	 * @var string
	 */
	protected $name="";
	
	/**
	 * Valor del control
	 * @var string
	 */
	protected $value="";
	
	/**
	 * Controla si el objeto será solo lectura o no
	 * @var boolean
	 */
	protected $readOnly=false;
	
	//protected $dataBaseValue="";
	
	/**
	 * Desde el autor: disables the text input mask
	 * @var boolean
	 */
	protected $maskInput= true;
	
	/**
	 * Desde el autor: enables the 12-hour format time picker
	 * @var boolean
	 */
	protected $pick12HourFormat= false;
	
	/**
	 * Desde el autor: disables seconds in the time picker
	 * @var boolean
	 */
	protected $pickSeconds= true;
	
	/**
	 * Desde el autor: set a minimum date
	 * @var string
	 */
	protected $startDate="";
	
	/**
	 * Desde el autor: set a maximum date
	 * @var string
	 */
	protected $endDate= "";
	
	/**
	 * Icono a renderizar al final del control
	 * @var string
	 */
	protected $appendedIcon="";
	
	/**
	 * Icono a renderizar al principio del control
	 * @var unknown_type
	 */
	protected $prependedIcon="";
	
	/**
	 * Determina si mostrará o no la vista para las horas en formato meridiano
	 * @var unknown_type
	 */
	protected $showMeridian=false;
	
	/**
	 * El control pedirá seleccionar la fecha y la hora
	 * @var number
	 */
	static $DATETIME_PICKER_TYPE_DATETIME=1;
	
	/**
	 * El control pedrirá seleccionar la fecha
	 * @var number
	 */
	static $DATETIME_PICKER_TYPE_DATE=2;
	
	/**
	 * El control pedirá seleccionar la hora
	 * @var number
	 */
	static $DATETIME_PICKER_TYPE_TIME=3;
	
	/**
	 * Año obtenido por la funcion setDate()
	 * @var string
	 */
	protected $year;
	/**
	 * Mes obtenido por la funcion setDate()
	 * @var string
	 */
	protected $month;
	/**
	 * Nombre del mes obtenido por la funcion setDate()
	 * @var unknown_type
	 */
	protected $monthStr;
	
	/**
	 * Dia obtenido por la funcion setDate()
	 * @var string
	 */
	protected $day;
	
	/**
	 * Hora obtenida por la funcion setDate()
	 * @var string
	 */
	protected $hour;
	
	/**
	 * Controla si la hora esta en formato d 24 horas o no
	 * @var boolean
	 */
	protected $hour24=false;
	
	/**
	 * Minutos obtenidos por la funcion setDate()
	 * @var string
	 */
	protected $minute;
	
	/**
	 * Segundos obtenidos por la funcion setDate()
	 * @var string
	 */
	protected $second;
	
	/**
	 * Controla si la hora en formato de 12 horas esta en am o pm, obtenido por la funcion setDate()
	 * @var string
	 */
	protected $ampm;
	
	
	/**
	 * Setea la fecha al control
	 * @param string $date Fecha a setear
	 * @param string $format Formato a setear. El separador aceptado para fechas es / o -, para tiempo es :
	 * @return boolean
	 */
	function setDate($date,$format){
		$valores=explode(" ",preg_replace("~[^0-9a-zA-Z]++~i"," ",$date));
		$formato=explode(" ",preg_replace("~[^0-9a-zA-Z]++~i"," ",$format));
	
		if(count($valores)<>count($formato)){
			return false;
		}
	
		foreach($formato as $key=>$var){
			switch ($var){
				case "p": case "P":
					$this->ampm=$valores[$key];
					break;
				case "s": case "ss":
					$this->second=$valores[$key];
					break;
				case "i": case "ii":
					$this->minute=$valores[$key];
					break;
				case "h": case "hh":
					$this->hour24=true;
					$this->hour=$valores[$key];
					break;
				case "H": case "HH":
					$this->hour24=false;
					$this->hour=$valores[$key];
					break;
				case "d": case "dd":
					$this->day=$valores[$key];
					break;
				case "m": case "mm":
					$this->month=$valores[$key];
					break;
				case "M": case "MM":
					$this->monthStr=$valores[$key];
					break;
				case "yy":	case "yyyy":
					$this->year=$valores[$key];
					break;
			}
		}
	}
	
	/**
	 * Obtiene el valor de la fecha en el formato asignado
	 * @param string $format Formato a devolver. El separador aceptado para fechas es / o -, para tiempo es :
	 * @return string Fecha en el formato establecido. Devolverá siempre primero los valores de las fechas y después los valores de las horas
	 */
	function getDate($format){
		$formato=explode(" ",preg_replace("~[^0-9a-zA-Z]++~i"," ",$format));
		if(strpos($format, "/")){
			$sep="/";
		}
	
		if(strpos($format, "-")){
			$sep="-";
		}
	
	
		$fecha="";
		$tiempo="";
	
		if(empty($this->ampm)){
			$this->ampm="am";
		}
	
		if(empty($this->hour)){
			$this->hour="00";
		}
	
		if(empty($this->minute)){
			$this->minute="00";
		}
	
		if(empty($this->second)){
			$this->second="00";
		}
	
		foreach($formato as $key=>$var){
			switch ($var){
				case "p": case "P":
					if($this->hour24){
						$hour=(int)$this->hour;
						if($hour>12){
							$tiempo.= ($var=="P"?" PM":" pm");
						}else{
							$tiempo.= ($var=="P"?" AM":" am");
						}
					}else{
						$tiempo.= " {$this->ampm}";
					}
					break;
				case "s": case "ss":
					$tiempo.= ($tiempo==""?$this->second:":{$this->second}");
					break;
				case "i": case "ii":
					$tiempo.= ($tiempo==""?$this->minute:":{$this->minute}");
					break;
				case "h": case "hh":
					if($this->hour24){
						$tiempo.= ($tiempo==""?$this->hour:":{$this->hour}");
					}else{
						$hora=(int)$this->hour;
						if($this->ampm=="pm"||$this->ampm=="PM"){
							$hora=$hora+12;
							$tiempo.= ($tiempo==""?$hora:":{$hora}");
						}else{
							$tiempo.= ($tiempo==""?$hora:":{$hora}");
						}
					}
					break;
				case "H": case "HH":
					if(!$this->hour24){
						$tiempo.= ($tiempo==""?$this->hour:":{$this->hour}");
					}else{
						$hora=(int)$this->hour;
						if($hora>12){
							$hora=$hora-12;
							$hora=(string)$hora;
								
								
							$hora=str_pad($hora,2,"0",STR_PAD_LEFT);
								
							$tiempo.= ($tiempo==""?$hora:":{$hora}");
						}else{
							$hora=str_pad($hour,2,"0",STR_PAD_LEFT);
							$tiempo.= ($tiempo==""?$hora:":{$hora}");
						}
					}
					break;
				case "d": case "dd":
					$fecha.= ($fecha==""?$this->day:"$sep{$this->day}");
					break;
				case "m": case "mm":
					$fecha.= ($fecha==""?$this->month:"$sep{$this->month}");
					break;
				case "M": case "MM":
					$fecha.= ($fecha==""?$this->monthStr:" {$this->monthStr}");
					break;
				case "yy":	case "yyyy":
					$fecha.= ($fecha==""?$this->year:"$sep{$this->year}");
					break;
			}
		}
	
		if($tiempo!==""){
			return "$fecha $tiempo";
		}else{
		return "$fecha";
		}
	}
	
	/**
	 * Convierte un valor a su respectivo formato para trabajar con la base de datos
	 * @param string $value Valor a convertir
	 * @param number $type Tipo de dato. Ver date_time::$DATETIME_PICKER_TYPE...
	 * @return mixed
	 */
	static function convertDateValueForDataBase($value,$type){
		$date="";
		
		switch ($type){
			case date_time::$DATETIME_PICKER_TYPE_DATE:
				$formatoBase=velkan::$config["datetimepicker"]["dateFormat"];
				$formatoAConvertir=velkan::$config["datetimepicker"]["dataBaseDateFormat"];
				
				break;
			case date_time::$DATETIME_PICKER_TYPE_TIME:
				$formatoBase=velkan::$config["datetimepicker"]["timeFormat"];
				$formatoAConvertir=velkan::$config["datetimepicker"]["dataBaseTimeFormat"];
				
				break;
			case date_time::$DATETIME_PICKER_TYPE_DATETIME:
				$formatoBase=velkan::$config["datetimepicker"]["dateTimeFormat"];
				$formatoAConvertir=velkan::$config["datetimepicker"]["dataBaseDateTimeFormat"];
	
				break;
		}
		
		$date=new self(array("id"=>"internal"));
		$date->setDate($value, $formatoBase);
		
		return $date->getDate($formatoAConvertir);
	}
	
	protected $pickerType=1;
	
	public function setMaskInput($value){
		$this->maskInput=$value;
	}
	
	public function setPickerType($type){
		$this->pickerType=$type;
	}
	
	public function setPick12HourFormat($value){
		$this->pick12HourFormat=$value;
	}
	
	public function setPickSeconds($value){
		$this->pickSeconds=$value;
	}
	
	public function setStartDate($value){
		$this->startDate=$value;
	}
	
	public function setEndDate($value){
		$this->endDate=$value;
	}
	
	/**
	 * Le indica al control si mostrará la vista con la hora meridiana
	 * @param boolean $value
	 */
	public function setShowMeridian($value){
		$this->showMeridian=$value;
	}
	
	/**
	 * Devuelve el nombre del control en el formulario
	 * @return string
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * Setea el nombre del control en el formulario
	 * @param string $value
	 */
	public function setName($value){
		$this->name=$value;
	}
	
	function __construct($args=array()){
		$this->assingVars($args);
		
		if(isset($args["startDate"])){
			$this->startDate=$args["startDate"];
		}
		
		if(isset($args["endDate"])){
			$this->endDate=$args["endDate"];
		}
		
		if(!isset($args["name"])){
			$this->name=$this->id;
		}else{
			$this->name=$args["name"];
		}
		
		if(isset($args["value"])){
			$this->value=$args["value"];
		}
		
		if(!isset($args["dataField"])){
			$this->dataField=$args["id"];
		}else{
			$this->dataField=$args["dataField"];
		}
		
		if(isset($args["pickerType"])){
			$this->setPickerType($args["pickerType"]);
			
		}else{
			$this->setPickerType(self::$DATETIME_PICKER_TYPE_DATETIME);
		}
		
		$this->setDataType();
		
		if(isset($args["maskInput"])){
			$this->maskInput=$args["maskInput"];
		}
		
		if(isset($args["pick12HourFormat"])){
			$this->pick12HourFormat=$args["pick12HourFormat"];
		}
		
		if(isset($args["showMeridian"])){
			$this->showMeridian=$args["showMeridian"];
		}else{
			$this->showMeridian=velkan::$config["datetimepicker"]["showMeridianView"];
		}
	}
	
	
	/**
	 * Setea la fecha minima que aceptará el control
	 * @param string $minDate
	 */
	function setMinDate($minDate){
		$this->minDate=$minDate;
	}
	
	/**
	 * Setea la fecha máxima que aceptará el control
	 * @param string $maxDate
	 */
	function setMaxDate($maxDate){
		$this->maxDate=$maxDate;
	}
	
	/**
	 * Formatea la propiedad value al formato definido para trabajar con la base de datos
	 */
	public function setValueFormatForDatabase(){
		$this->value=self::convertDateValueForDataBase($this->value,$this->pickerType);
	}
	
	/**
	 * Setea el valor del control
	 * @param string $value
	 */
	public function setValue($value){
		$this->value=$value;
	}
	
	/**
	 * Devuelve el valor del control
	 * @return string
	 */
	public function getValue(){
		return $this->value;
	}
	
	/**
	 * Setea si el control sera de solo lectura o no
	 * @param boolean $value
	 */
	public function setReadOnly($value){
		$this->readOnly=$value;
	}
	
	/**
	 * Renderiza el control
	 * @param boolean $return Determina si devolverá valores o si imprimirá en pantalla
	 * @return string
	 */
	function render($return=false){
		
		if($this->readOnly){
			$render="<input type=\"hidden\" name=\"{$this->name}\" id=\"{$this->id}\" value=\"{$this->value}\"><span class='velkan-read-only'>{$this->value}</span>";
		}else{
		
			if($this->appendedIcon==""){
				$this->appendedIcon="icon-calendar";
			}
			
			$class=$this->class==""?velkan::$config["datetimepicker"]["inputClass"]:$this->class;
			
			$formatViewType="";
			
			switch($this->pickerType){
				case self::$DATETIME_PICKER_TYPE_DATE:
					$dateFormat=velkan::$config["datetimepicker"]["dateFormat"];
					$dateFormatDB=velkan::$config["datetimepicker"]["dataBaseDateFormat"];
					$startView="2";
					$minView="2";
					$maxView="4";
					break;
				case self::$DATETIME_PICKER_TYPE_DATETIME:
					$dateFormat=velkan::$config["datetimepicker"]["dateTimeFormat"];
					$dateFormatDB=velkan::$config["datetimepicker"]["dataBaseDateTimeFormat"];
					$startView="2";
					$minView="0";
					$maxView="4";
					break;
				case self::$DATETIME_PICKER_TYPE_TIME:
					$dateFormat=velkan::$config["datetimepicker"]["timeFormat"];
					$dateFormatDB=velkan::$config["datetimepicker"]["dataBaseTimeFormat"];
					$startView="1";
					$minView="0";
					$maxView="1";
					$formatViewType="time";
					break;
			}
			
			$val="value='{$this->value}' data-value='{$this->value}' data-date-format='$dateFormat'";
			//$dataBaseValue="value = '{$this->dataBaseValue}' data-date-format = '$dateFormatDB'";
			$render="";
			
			$render.="<div class='input-append date' id='{$this->id}_THECONTAINER_' $val>";
			
			$render.="<input id='{$this->id}' name='{$this->name}' container-id='{$this->id}_THECONTAINER_' type='text' class='input-medium' velkandate=\"true\" $val data-date-format='$dateFormat'>";
			/*$render.="<input id='{$this->id}_DATABASEFORMAT_' 
						name='{$this->name}' 
						type='hidden' 
						$dataBaseValue 
						container-id='{$this->id}_THECONTAINER_'
						main-input-id='{$this->id}' 
						velkandate=\"true\">";*/
			
			if($this->appendedIcon!==""){
				$render.="<span class='add-on'><i class='{$this->appendedIcon}'></i></span>";
			}
			
			if($this->appendedIcon!==""||$this->prependedIcon!==""){
				$render.="</div>";
			}
			
			//$hideOnClick=(velkan::$config["datetimepicker"]["hideOnClic"]?".on('changeDate', function(dp){\$('#{$this->id}_THECONTAINER_').datetimepicker('hide');})":"");
			$hideOnClick=(velkan::$config["datetimepicker"]["hideOnClic"]?",autoclose:true":"");
			$js="$('#{$this->id}_THECONTAINER_').datetimepicker({";
			
			$js.="format:'$dateFormat' $hideOnClick";
			
			$js.=",startView: $startView, minView: $minView, maxView: $maxView";
			
			if($formatViewType!==""){
				$js.=",formatViewType : '$formatViewType'";
			}
			
			if($this->showMeridian){
				$js.=",showMeridian:true";
			}else{
				$js.=",showMeridian:false";
			}
			
			$js.=",pickerPosition:'bottom-right'";
			switch ($this->pickerType){
				case self::$DATETIME_PICKER_TYPE_DATE:
					$js.=",pickTime: false";
					break;
				case self::$DATETIME_PICKER_TYPE_TIME:
					$js.=",pickDate: false";
					break;
			}
			
			if(!$this->maskInput){
				$js.=",maskInput: false";
			}
			
			if($this->pick12HourFormat){
				$js.=",pick12HourFormat: true";
			}
			
			if(!$this->pickSeconds){
				$js.=",pickSeconds: false";
			}
			
			if(!empty($this->startDate)&&$this->startDate!==""){
				$js.=",startDate: '".$this->startDate."'";
			}
			
			if(!empty($this->endDate)&&$this->endDate!==""){
				$js.=",endDate: '".$this->endDate."'";
			}
			
			//$js.=",linkField:'{$this->id}_DATABASEFORMAT_',linkFormat:'$dateFormatDB'";
			
			$js.="}).data('datetimepicker');";
			
			if(!empty($this->value)&&$this->value!==""){
				$js.="$('#{$this->id}_THECONTAINER_').datetimepicker('setValue','$this->value');";
			}
			
			page::addJavaScriptOnLoad(PHP_EOL.$js.PHP_EOL);
		}
		
		if(!$return){
			echo $render;
		}else{
			return $render;
		}
	}
}