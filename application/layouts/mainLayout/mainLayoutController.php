<?php
class mainLayout extends controller{
	function validations(){
		if(!user::_isDataInitialized()||!session::_validateLifeTime()){
			velkan::redirect("logout/");
			return false;
		}
		return true;
	}
}