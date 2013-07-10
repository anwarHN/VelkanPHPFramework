<?php
class widget_velkan_menu{
	private $html;
	private $params;
	
	protected $items=array();
	protected $links=array();
	
	public function setParams(array $args){
		$this->params=$args;
		$this->createMenu();
	}
	
	private function createMenu(){
		$count=0;
		extract($this->params);
		
		$this->html='<ul class="'.$class.'">';
		
		$this->items=$items;
		
		foreach ($this->items as $item=>$link){
			$this->scanItems($item,$link,0);
			
			$count+=1;
		}
		
		$this->html.='</ul>';
	}
	
	
	private function scanItems($item,$link,$level){
		if(is_array($link)){
			if($level==0){
				$this->html.="<li class='dropdown'><a class='dropdown-toggle' data-toggle='dropdown' href='javascript:void(0);'>$item<b class='caret'></b></a><ul class='dropdown-menu'>";
			}else{
				$this->html.="<li class='dropdown-submenu'><a href='javascript:void(0);'>$item</a><ul class='dropdown-menu'>";
			}
			foreach($link as $subItem=>$subLink){
				$this->scanItems($subItem,$subLink,$level+1);
			}
			$this->html.="</ul></li>";
		}else{
			if($item=="-"){
				$this->html.='<li class="divider"></li>';
			}else{
				$this->html.='<li><a href="?c='.$link.'">'.$item.'</a></li>';
			}
			
		}
	}
	
	public function render(){
		echo $this->html;
	}
}