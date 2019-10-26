<?php
namespace CTI;

require_once './bootstrap.php';
require_once './service/auth.php';
require_once './service/router.php';

$path = $_SERVER['PATH_INFO'];
$authorizer = new AuthService;
$router = new Router;
if($path === '/') {

	require_once './components/home/home.php';
	page(NULL, function ($context) {
		return new HomePage($context);
	});

} elseif($path === '/scanner') {

	if (!$authorizer->verifyToken('scanner')) {
		error_log("Token not valid");
		$router->redirect("/");
	}

	require_once './components/scanner/scanner.php';
	page(NULL, function ($context) {
		return new ScannerPage($context);
	});

} elseif(substr($path, 0, strlen("/admin/")) === "/admin/") {

	if (!$authorizer->verifyToken('admin')) {
		error_log("Token not valid");
		$router->redirect("/");
	}

	if($path === '/admin/tickets.php') {

		require_once './components/ticket/tickets.php';
		page('tickets', function ($context) {
			return new TicketSearchPage($context);
		});
	
	} elseif($path === '/admin/ticket_detail.php') {
	
		require_once './components/ticket/ticket_detail.php';
		page('tickets', function ($context) {
			return new TicketDetailPage($context);
		});
	
	} else if($path === '/admin/designs.php') {
	
		require_once './components/designer/designs.php';
		page('designs', function ($context) {
			return new DesignSearchPage($context);
		});
	
	} else if($path === '/admin/designer.php') {
	
		require_once './components/designer/designer.php';
		page('designer', function ($context) {
			return new DesignerPage($context);
		});
	
	} elseif($path === '/admin/tours.php') {
	
		require_once './components/tour/tours.php';
		page('tours', function ($context) {
			return new TourSearchPage($context);
		});
	
	} elseif($path === '/admin/tour-positions') {
		
		require_once './components/tour-positions/tour-positions.php';
		page('tourpositions', function ($context) {
			return new TourpositionSearchPage($context);
		});
	
	} elseif(substr($path, 0, strlen("/admin/tour-position")) === "/admin/tour-position") {
		
		require_once './components/tour-positions/tour-position.php';
		page('tourposition', function ($context) {
			return new TourpositionDetailPage($context);
		});

	} elseif($path === '/admin/process.php') {
	
		echo file_get_contents($_FILES['files']['tmp_name'][0]);
		
	} else {

		// TODO: NOT FOUND PAGE
	}

} elseif(substr($path, 0, strlen("/rest/admin/")) === "/rest/admin/") {

	if (!$authorizer->verifyToken('admin')) {
		error_log("Token not valid");
		$router->redirect("/");
	}

	if(substr($path, 0, strlen("/rest/admin/ticket-templates")) === "/rest/admin/ticket-templates") {
		
		bootstrap(function ($context) {
			echo $context->ticketTemplateResource()->process();
		});
	
	}

} else {

	// TODO: NOT FOUND PAGE
}
?>