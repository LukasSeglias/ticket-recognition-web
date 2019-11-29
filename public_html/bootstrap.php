<?php
namespace CTI;

require_once './app.php';
require_once './context.php';
require_once './service/database.php';
require_once './service/router.php';
require_once './service/auth.php';
require_once './service/ticket-template.php';
require_once './service/message.php';
require_once './service/exception-mapper.php';
require_once './repository/tour-operator.php';
require_once './repository/text-definition.php';
require_once './repository/ticket-template.php';
require_once './repository/tour-position.php';
require_once './repository/tour.php';
require_once './repository/ticket.php';
require_once './repository/ticket-position.php';
require_once './json/ticket-template.php';
require_once './json/message.php';
require_once './i18n/i18n.php';
require_once './ws/ticket-template.php';
require_once './io/ticket-template.php';
require_once './validation/ticket-template.php';
require_once './validation/tour-position.php';
require_once './validation/tour-operator.php';
require_once './validation/tour.php';
require_once './validation/ticket.php';
require_once './components/navigation/navigation.php';
require_once './components/messages/messages.php';

function bootstrap($callback) {

	$dbPassword = file_get_contents(getenv('DB_PASSWORD_FILE'));
	$databaseService = new DatabaseService(getenv('DB_CONNECTION'), getenv('DB_USER'), $dbPassword);

	$router = new Router();
	$authService = new AuthService();
	$textDefinitionRepository = new TextDefinitionRepository($databaseService);
	$touroperatorRepository = new TouroperatorRepository($databaseService);
	$tourPositionRepository = new TourPositionRepository($databaseService);
	$tourRepository = new TourRepository($databaseService, $tourPositionRepository);
	$ticketTemplateRepository = new TicketTemplateRepository($databaseService, $textDefinitionRepository, $touroperatorRepository);
	$ticketTemplateService = new TicketTemplateService($ticketTemplateRepository);
	$ticketPositionRepository = new TicketPositionRepository($databaseService);
	$ticketRepository = new TicketRepository($databaseService, $ticketPositionRepository);
	$ticketValidator = new TicketValidator();
	$ticketTemplateJsonMapper = new TicketTemplateJsonMapper();
	$messageJsonMapper = new MessageJsonMapper();
	$ticketTemplateImageRepository = new TicketTemplateImageRepository();
	$tourpositionValidator = new TourpositionValidator();
	$touroperatorValidator = new TouroperatorValidator();
	$ticketTemplateValidator = new TicketTemplateValidator();
	$tourValidator = new TourValidator();
	$messageService = new MessageService();
	$exceptionMapper = new ExceptionMapper();
	$context = new Context($router, $authService, $databaseService,
		$messageService,
		$textDefinitionRepository, 
		$tourRepository,
		$tourValidator,
		$touroperatorRepository, 
		$touroperatorValidator,
		$ticketTemplateRepository,
		$messageJsonMapper,
		$tourPositionRepository,
		$tourpositionValidator,
		$ticketTemplateValidator,
		$ticketTemplateService,
		$ticketTemplateJsonMapper,
		$ticketTemplateImageRepository,
		$ticketRepository,
		$ticketPositionRepository,
		$ticketValidator,
		$exceptionMapper
	);
	$callback($context);
}

function resource($resourceConstructionFunction) {
	bootstrap(function($context) use (&$resourceConstructionFunction) {
		$resource = $resourceConstructionFunction($context);
		echo $resource->process();
	});
};

function page($navigationItems, $activeKey, $pageConstructionFunction) {
	bootstrap(function($context) use (&$navigationItems, &$activeKey, &$pageConstructionFunction) {

		$navigation = new Navigation($context, $navigationItems, $activeKey);
		$messages = new MessagesComponent($context);
		$page = $pageConstructionFunction($context);
		$app = new App($context, $page, [
			'navigation' => $navigation,
			'messages' => $messages
		]);
		$app->update();
		echo $app->render();
	});
};

function scannerPage($activeKey, $pageConstructionFunction) {
	$navigationItems = [
		new NavigationItem('scanner', '/scanner', Texts::navigation_scanner, [])
	];
	page($navigationItems, $activeKey, $pageConstructionFunction);
};

function adminPage($activeKey, $pageConstructionFunction) {
	$navigationItems = [
		new NavigationItem('templates', '/admin/templates', Texts::navigation_templates, []),
		new NavigationItem('tickets', '/admin/tickets', Texts::navigation_tickets, []),
		new NavigationItem('tours', '/admin/tours', Texts::navigation_tours, []),
		new NavigationItem('tourpositions', '/admin/tour-positions', Texts::navigation_tourpositions, []),
		new NavigationItem('touroperators', '/admin/tour-operators', Texts::navigation_touroperators, []),
		new NavigationItem('users', '/auth/', Texts::navigation_users, [])
	];
	page($navigationItems, $activeKey, $pageConstructionFunction);
};
?>