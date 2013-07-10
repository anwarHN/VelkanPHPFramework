<?php
class captchaController extends controller{
	public function index($args=array()){
		$this->setLayout("indexLayout");
		$this->render->view("captcha", $args);
	}
}