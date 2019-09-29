<?php
namespace CTI;
use \mysqli;

require_once './vendor/autoload.php';
require_once './i18n/i18n.php';
require_once './templates/templates.php';
require_once './crud_mode.php';
require_once './validation.php';
require_once './component.php';
require_once './components/login/login_form.php';
require_once './components/navigation/navigation.php';
require_once './components/ticket/ticket_form.php';
require_once './components/ticket/ticketposition_list.php';
require_once './model/ticket.php';
require_once './model/user.php';

class InputComponentState {
	
	private $value;
	private $validationResult;
	private $disabled;
	
	function __construct($value, $validationResult, $disabled) {
		$this->value = $value;
		$this->validationResult = $validationResult;
		$this->disabled = $disabled;
	}

	public function value() {
		return $this->value;
	}
	
	public function validationResult() {
		return $this->validationResult;
	}
	
	public function disabled() {
		return $this->disabled;
	}
}


$ticket = new Ticket(1203, 'TO 3B', 'TC765', '2019-09-27', [
	new TicketPosition("B6123", "Bootsfahrt auf dem Bodensee"),
	new TicketPosition("C2443", "Romantisches Abendessen"),
	new TicketPosition("A1236", "Tageskarte Seilbahn")
]);

$templatingEngine = new \CTI\TemplatingEngine();
echo $templatingEngine->render('index.html', [
	'loginForm' => new LoginFormComponent(new LoginFormComponentState(
		new InputComponentState('', ValidationResult::invalid('Invalid email'), false),
		new InputComponentState('', ValidationResult::none(), false)
	)),
	'ticketFormCreate' => new TicketFormComponent(new TicketFormComponentState(
		$ticket, CrudMode::create()
	)),
	'ticketPositionListCreate' => new TicketPositionListComponent(new TicketPositionListComponentState(
		$ticket, CrudMode::create()
	)),
	'ticketFormView' => new TicketFormComponent(new TicketFormComponentState(
		$ticket, CrudMode::view()
	)),
	'ticketPositionListView' => new TicketPositionListComponent(new TicketPositionListComponentState(
		$ticket, CrudMode::view()
	)),
	'navigation' => new NavigationComponent(new NavigationComponentState(
		[
			new NavigationItem('#', L::navigation_designer, true),
			new NavigationItem('#', L::navigation_tickets, false),
			new NavigationItem('#', L::navigation_tours, false),
			new NavigationItem('#', L::navigation_ticketpositions, false)
		],
		new User('seglias', 'Lukas', 'Seglias')
	))
]);


$host = 'mysql';
$user = 'root';
$pass = 'rootpassword';
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to MySQL successfully!";
}

?>