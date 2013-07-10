<?php
class widget_velkan_drop_down{
	private $html;
	private $params;
	
	
	public function setParams(array $args){
		$this->params=$args;
		$this->createDropDown();
	}
	
	private function createDropDown(){
		extract($this->params);
		
		$float="pull-$float";
		
		$count=0;
		$html="<ul class=\"$class $float\">
				  <li class=\"dropdown\">
					<a href=\"$displayLink\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">$display<b class=\"caret\"></b>
					</a>";
		
		$html.="<ul class=\"dropdown-menu\">";
		
		foreach($items as $key=>$value){
			$html.="<li><a href=\"?c=".$value."\">".$key."</a></li>";
		}
		
		$html.="</ul></li></ul>";
		
		$this->html=$html;
	}
	
	public function render(){
		echo $this->html;
	}
}