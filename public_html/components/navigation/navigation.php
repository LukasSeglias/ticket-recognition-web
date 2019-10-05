<?php
namespace CTI;

require_once './i18n/i18n.php';
require_once './components/component.php';
require_once './model/user.php';

class Navigation implements Component {

	const KEY_DESIGNS = 'designs';
	const KEY_TICKETS = 'tickets';
	const KEY_TOURS = 'tours';
	const KEY_TICKETPOSITIONS = 'ticketpositions';

	private $component;

	function __construct($context, $activeKey) {

		$this->component = new NavigationComponent(new NavigationComponentState(
			[
				new NavigationItem(self::KEY_DESIGNS, 'designs.php', Texts::navigation_designer, [

				]),
				new NavigationItem(self::KEY_TICKETS, 'tickets.php', Texts::navigation_tickets, [

				]),
				new NavigationItem(self::KEY_TOURS, 'tours.php', Texts::navigation_tours, [

				]),
				new NavigationItem(self::KEY_TICKETPOSITIONS, 'ticketpositions.php', Texts::navigation_ticketpositions, [

				])
			],
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
	
	function __construct(array $items, string $activeKey, User $user) {
		$this->items = $items;
		$this->activeKey = $activeKey;
		$this->user = $user;
	}
	
	public function items() : array {
		return $this->items;
	}

	public function activeKey() : string {
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