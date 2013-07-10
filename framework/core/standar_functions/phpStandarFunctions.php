<?php
	/**
	 * Convierte las fechas a formato para mysql
	 * @param string $fechavieja
	 * @return string
	 */
	function date_ymd($fechavieja){	
		list($d,$m,$a)=explode("/",$fechavieja);
		return $a."-".$m."-".$d;
	}
	function date_24($hora){
		$h=strtotime($hora);
		$h=date("H:i",$h);
		
		return $h;
	}
	
	function getArrayDefinition(array $arr){
		$value="";
		foreach($arr as $key=>$val){
			if($value!==""){
				$value.=",";
			}
			$keyStr="";
			if($key==""){
				$keyStr="";
			}else{
				$keyStr="\"$key\"=>";
			}
			
			if(is_array($val)){
				$value.="$keyStr".getArrayDefinition($val);
			}else{
				if(is_string($val)){
					$value.="$keyStr\"$val\"";
				}else{
					if(is_bool($val)){
						if($val){
							$value.="{$keyStr}true";
						}else{
							$value.="{$keyStr}false";
						}
					}else{
						$value.="$keyStr$val";
					}
				}
			}
		}
		return "array($value)";
	}
?>