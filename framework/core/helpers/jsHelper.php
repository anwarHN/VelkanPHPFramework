<?php
class jsHelper {
	static function callFunction($method, $controller=""){
		if(empty($controller)||$controller==""){
			$js="callFunc('$method');";
		}else{
			$js="redirect('$controller','$method');";
		}
		
		return $js;
	}
	
	static function confirmCallFunction($title,$message,$method,$controller=""){
		$yes=velkan::$lang["htmlHelper"]["confirmAction"]["yes"];
		$no=velkan::$lang["htmlHelper"]["confirmAction"]["no"];
	
		$registry=registry::getInstance();
	
		if(empty($controller)||$controller==""){
			$controller=$registry->controllerName;
		}
		
		$html=<<<HTML
			<div id="confirmAction" class="modal hide fade">
				<div class="modal-header">
			    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			      	<h3 id="confirmActionTitle"></h3>
			    </div>
			    <div class="modal-body" id="confirmActionMessage"></div>
			    <div class="modal-footer">
			    	<a href="javascript:void(0);" id="confirmActionYes" class="btn btn-danger">$yes</a>
      				<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-secondary">$no</a>
			    </div>
			</div>
HTML;
		page::appendHtml("confirmAction", $html);
		
		$js="function confirmAction(title,message,method,controller){";
		$js.="$('#confirmActionYes').click(function(){";
		$js.="redirect(controller,method);";
		$js.="});";
		$js.="$('#confirmActionTitle').html(title);";
		$js.="$('#confirmActionMessage').html(message);";
		$js.="$('#confirmAction').modal('show');";
		$js.="}";
	
		page::addJavaScript($js);
		
		$return="confirmAction('$title','$message','$method','$controller');";
		
		return $return;
	}
}