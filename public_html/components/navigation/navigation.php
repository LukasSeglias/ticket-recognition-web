<?php
namespace CTI;

require_once './components/component.php';
require_once './model/user.php';

class Navigation implements Component {

	private $component;

	function __construct($context, $navigationItems, $activeKey) {

		$this->component = new NavigationComponent(new NavigationComponentState(
			$navigationItems,
			$activeKey,
			$context->authService()->currentUser()
		));
	}

	public function template() : string {
		return $this->component->template();
	}
	
	public function context() : array {
		return $this->component->context();
	}
}

class NavigationComponent implements Component {
	
	private $state;
	
	function __construct(NavigationComponentState $state) {
		$this->state = $state;
	}
	
	public function template() : string {
		return 'navigation/navigation.html';
	}
	
	public function context() : array {
		return [
			'items' => $this->state->items(),
			'activeKey' => $this->state->activeKey(),
			'user' => $this->state->user()
		];
	}
}

class NavigationComponentState {
	
	private $items;
	private $activeKey;
	private $user;
	
	function __construct(array $items, $activeKey, User $user) {
		$this->items = $items;
		$this->activeKey = $activeKey;
		$this->user = $user;
	}
	
	public function items() : array {
		return $this->items;
	}

	public function activeKey() {
		return $this->activeKey;
	}
	
	public function user() : User {
		return $this->user;
	}
}

class NavigationItem {
	
	private $key;
	private $href;
	private $label;
	private $children;
	
	function __construct(string $key, string $href, string $label, array $children) {
		$this->key = $key;
		$this->href = $href;
		$this->label = $label;
		$this->children = $children;
	}
	
	public function key() : string {
		return $this->key;
	}

	public function href() : string {
		return $this->href;
	}
	
	public function label() : string {
		return $this->label;
	}
	
	public function children() : array {
		return $this->children;
	}
}
?>