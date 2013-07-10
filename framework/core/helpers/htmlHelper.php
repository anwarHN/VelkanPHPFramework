<?php
class htmlHelper{	
	static function breadcrumbs($path=array()){
		$render="";
		if(!empty($path)){
			foreach($path as $key=>$data){
				if($data["active"]){
					$render.="<li class=\"active\">{$data["text"]}</li>";
				}else{
					$render.="<li><a href=\"javascript:void(0)\" onclick=\"{$data["call"]}\">{$data["text"]}</a><span class=\"divider\">/</span></li>";
				}
			}
		}else{
			$registry=registry::getInstance();
			
			$homeCaption=velkan::$lang["htmlHelper"]["breadcrumbs"]["homeCaption"];
			$homeUrl=explode("/",velkan::$config["htmlHelper"]["breadcrumbs"]["homeUrl"]);
			$controllerName=$registry->controllerName;
			$methodName=$registry->controllerMethod;
			$controllerTitle=$registry->controllerTitle;
			$methodTitle=$registry->controllerMethodTitle;
			
			if(empty($controllerTitle)||$controllerTitle==""){
				$controllerTitle=preg_split("/(?=[A-Z])/", $controllerName);
				$controllerTitle=ucfirst(implode(" ", $controllerTitle));
			}
			
			if(empty($methodTitle)||$methodTitle==""){
				$methodTitle=preg_split("/(?=[A-Z])/", $methodName);
				$methodTitle=ucfirst(implode(" ", $methodTitle));
			}
			
			if($controllerName==$homeUrl[0]&&$methodName==$homeUrl[1]){
				$render.="<li class=\"active\">{$homeCaption}</li>";
			}else{
				if($controllerName=="index"&&$methodName=="index"){
					$render.="<li><a href=\"javascript:void(0)\" onclick=\"".jsHelper::callFunction("","")."\">{$homeCaption}</a><span class=\"divider\">/</span></li>";
				}else{
					$render.="<li><a href=\"javascript:void(0)\" onclick=\"".jsHelper::callFunction($homeUrl[1],$homeUrl[0])."\">{$homeCaption}</a><span class=\"divider\">/</span></li>";
				}
				if($methodName=="index"){
					$render.="<li class=\"active\">{$controllerTitle}</li>";
				}else{
					$render.="<li><a href=\"javascript:void(0)\" onclick=\"".jsHelper::callFunction("",$controllerName)."\">{$controllerTitle}</a><span class=\"divider\">/</span></li>";
					$render.="<li class=\"active\">{$methodTitle}</li>";
				}
			}
		}
		
		echo "<ul class=\"breadcrumb\">".$render."</ul>";		
	}
	
	static function button($caption,$type,$class="",$onclick=""){
		$class=($class==""?"":"class='$class'");
		$onclick=($onclick==""?"":"onclick='$onclick'");
		echo "<button type='$type' $class $onclick>$caption</button>";
	}
}
?>