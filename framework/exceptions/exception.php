<?php
/**
 * Velkan PHP Framework
 * Manejador de excepciones. Mostrará mayor informacion si la configuracion tiene activado el debug.
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2012 Anwar Garcia
 * @version    v1.0
 * @see http://www.phpclasses.org/browse/file/15510.html
 */
class VException extends Exception{
	public function log(){
		$dir=velkan::$config["debug"]["savePath"];
		
		ini_set('error_log', $dir);
		$message = $this->message();
		error_log($message,3,$dir."/velkan.log");
		return $this;
	}
	
	function message(){
		$msg="**************************************************".PHP_EOL;
		$msg.=date('D, d M Y H:i:s').PHP_EOL;
		$msg.="Velkan Exception:".PHP_EOL;
		$msg.= $this->getMessage().PHP_EOL;
		
		foreach ($this->getTrace() as $num => $trace){
			$msg .= empty($trace['file']) ? 'Unknown file' : $trace['file'].PHP_EOL;
			$msg .= empty($trace['line']) ? 'Unknown line' : $trace['line'].PHP_EOL;
			$msg .= "Number: ". $num . ", " . $text .PHP_EOL;
			
			$msg.=$trace;
		}
		return $msg;
	}
	
	function display(){
		echo "<pre>";
		echo '<h2>Velkan Exception:</h2>';
		echo '<h1>' . $this->getMessage() . '</h1>';
		echo <<<SCRIPT
		<script>
		function error_reporter_toogle(id) {
		var style = document.getElementById(id).style
		if (style.display == 'block')
			style.display = 'none'
			else
			style.display = 'block'
			 
			return false
		}
		</script>
SCRIPT;
		echo '<ol>';
		 
		foreach ($this->getTrace() as $num => $trace){
		$text  = empty($trace['file']) ? 'Unknown file' : $trace['file'];
			$text .= ', ';
			$text .= empty($trace['line']) ? 'Unknown line' : $trace['line'];
			echo '<li>';
			echo '<a href="#" onclick="return error_reporter_toogle(\'m' . $num . '\')" >' . $text . '</a>';
			echo '<pre id="m' . $num . '" style="display:none;">';
					var_dump($trace);
					echo '</pre>';
			echo '</li>';
		}
		
		echo '</ol>';
		echo "</pre>";
	}
	
	public function process(){
		$debug = velkan::$config["debug"]["enabled"];
		if ($debug){
			$this->display();
		}else{
			$this->log();
		}
		
		return $this;
	}
}