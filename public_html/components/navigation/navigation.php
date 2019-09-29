<?php
namespace CTI;

class NavigationComponent implements Component {
	
	private $state;
	
	function __construct($state) {
		$this->state = $state;
	}
	
	public function template() {
		return 'navigation/navigation.html';
	}
	
	public function context() {
		return [
			'items' => $this->state->items(),
			'user' => $this->state->user()
		];
	}
}

class NavigationComponentState {
	
	private $items;
	private $user;
	
	function __construct($items, $user) {
		$this->items = $items;
		$this->user = $user;
	}
	
	public function items() {
		return $this->items;
	}
	
	public function user() {
		return $this->user;
	}
}

class NavigationItem {
	
	private $href;
	private $label;
	private $active;
	
	function __construct($href, $label, $active) {
		$this->href = $href;
		$this->label = $label;
		$this->active = $active;
	}
	
	public function href() {
		return $this->href;
	}
	
	public function label() {
		return $this->label;
	}
	
	public function active() {
		return $this->active;
	}
}
?>