<?php
namespace CTI;

interface Component {
	
	public function template();
	
	public function context();
}

class AbstractComponent implements Component {
	
	private $template;
	private $context;
	
	function __construct($template, $context) {
		$this->template = $template;
		$this->context = $context;
	}
	
	public function template() {
		return $this->template;
	}
	
	public function context() {
		return $this->context;
	}

}
?>