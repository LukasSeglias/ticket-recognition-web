<?php
namespace CTI;

require_once './app.php';
require_once './context.php';
require_once './service/database.php';
require_once './service/router.php';
require_once './service/auth.php';
require_once './service/ticket.php';
require_once './service/ticket-template.php';
require_once './repository/tour-operator.php';
require_once './repository/text-definition.php';
require_once './repository/ticket-template.php';
require_once './repository/tour-position.php';
require_once './json/ticket-template.php';
require_once './ws/ticket-template.php';
require_once './components/navigation/navigation.php';

function bootstrap($callback) {

	$dbPassword = file_get_contents(getenv('DB_PASSWORD_FILE'));
	$databaseService = new DatabaseService(getenv('DB_CONNECTION'), getenv('DB_USER'), $dbPassword);

	$router = new Router();
	$authService = new AuthService();
	$ticketService = new TicketService($databaseService);
	$textDefinitionRepository = new TextDefinitionRepository($databaseService);
	$touroperatorRepository = new TouroperatorRepository($databaseService);
	$tourPositionRepository = new TourPositionRepository($databaseService);
	$ticketTemplateRepository = new TicketTemplateRepository($databaseService, $textDefinitionRepository, $touroperatorRepository);
	$ticketTemplateService = new TicketTemplateService($ticketTemplateRepository);
	$ticketTemplateJsonMapper = new TicketTemplateJsonMapper();
	$ticketTemplateResource = new TicketTemplateResource($router, $ticketTemplateService, $ticketTemplateJsonMapper);
	$context = new Context($router, $authService, $ticketService, $databaseService,
		$textDefinitionRepository, $touroperatorRepository, $ticketTemplateRepository,
		$tourPositionRepository,
		$ticketTemplateService,
		$ticketTemplateJsonMapper,
		$ticketTemplateResource
	);
	$callback($context);
}

function page($activeKey, $pageConstructionFunction) {
	bootstrap(function($context) use (&$activeKey, &$pageConstructionFunction) {
		$navigation = new Navigation($context, $activeKey);
		$page = $pageConstructionFunction($context);
		$app = new App($context, $page, [
			'navigation' => $navigation
		]);
		$app->update();
		echo $app->render();
	});
};
?>