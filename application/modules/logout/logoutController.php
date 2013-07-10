<?php
class logoutController extends controller{
	function index(){
		$error=session::_endSession();
		velkan::redirect("index/");
	}
} 
?>