<?php
namespace CTI;

require_once './app.php';
require_once './context.php';
require_once './service/database.php';
require_once './service/router.php';
require_once './service/auth.php';
require_once './service/ticket.php';
require_once './components/navigation/navigation.php';

function bootstrap($activeKey, $pageConstructionFunction) {

	$dbConfig = parse_ini_file("/etc/opt/ticket-recognition-web/db.ini");
	$databaseService = new DatabaseService($dbConfig);

	$router = new Router();
	$authService = new AuthService();
	$ticketService = new TicketService($databaseService);
	$context = new Context($router, $authService, $ticketService, $databaseService);
	$navigation = new Navigation($context, $activeKey);

	$page = $pageConstructionFunction($context);
	$app = new App($context, $page, [
		'navigation' => $navigation
	]);
	$app->update();
	echo $app->render();
}
?>