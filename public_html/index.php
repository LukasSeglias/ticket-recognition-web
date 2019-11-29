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

	if($path === '/admin/tickets') {

		require_once './components/ticket/tickets.php';
		page('tickets', function ($context) {
			return new TicketSearchPage($context);
		});
	
	} elseif(substr($path, 0, strlen("/admin/ticket-position")) === "/admin/ticket-position") {
		
		require_once './components/ticket/ticket_position.php';
        page('tickets', function ($context) {
            return new TicketPositionPage($context);
        });

    } elseif(substr($path, 0, strlen("/admin/ticket")) === "/admin/ticket") {

        require_once './components/ticket/ticket_detail.php';
        page('tickets', function ($context) {
            return new TicketDetailPage($context);
        });

    } elseif($path === '/admin/ticket_detail.php') {
	
		require_once './components/ticket/ticket_detail.php';
		page('tickets', function ($context) {
			return new TicketDetailPage($context);
		});
	
	} else if($path === '/admin/templates') {
	
		require_once './components/designer/designs.php';
		page('templates', function ($context) {
			return new DesignSearchPage($context);
		});
	
	} else if(substr($path, 0, strlen("/admin/designer")) === "/admin/designer") {
	
		require_once './components/designer/designer.php';
		page('templates', function ($context) {
			return new DesignerPage($context);
		});
	
	} elseif($path === '/admin/tour-positions') {
		
		require_once './components/tour-positions/tour-positions.php';
		page('tourpositions', function ($context) {
			return new TourpositionSearchPage($context);
		});
	
	} elseif(substr($path, 0, strlen("/admin/tour/position")) === "/admin/tour/position") {
		
		require_once './components/tours/tour_position.php';
        page('tourpositions', function ($context) {
            return new TourPositionPage($context);
        });

    } elseif(substr($path, 0, strlen("/admin/tour-position")) === "/admin/tour-position") {
		
		require_once './components/tour-positions/tour-position.php';
		page('tourpositions', function ($context) {
			return new TourpositionDetailPage($context);
		});

	} elseif($path === '/admin/tour-operators') {
		
		require_once './components/tour-operators/tour-operators.php';
		page('touroperators', function ($context) {
			return new TouroperatorSearchPage($context);
		});
	
	} elseif(substr($path, 0, strlen("/admin/tour-operator")) === "/admin/tour-operator") {
		
		require_once './components/tour-operators/tour-operator.php';
		page('touroperators', function ($context) {
			return new TouroperatorDetailPage($context);
		});

	} elseif($path === '/admin/tours') {
	
		require_once './components/tours/tours.php';
		page('tours', function ($context) {
			return new TourSearchPage($context);
		});
	
	} elseif(substr($path, 0, strlen("/admin/tour")) === "/admin/tour") {
		
		require_once './components/tours/tour.php';
		page('tours', function ($context) {
			return new TourDetailPage($context);
		});

	} elseif(substr($path, 0, strlen("/admin/images/ticket-template/")) === "/admin/images/ticket-template/") {
		
		$filename = end(explode('/', getenv('REQUEST_URI')));
		$filename = basename($filename);
		$filepath = getenv('CTI_IMAGE_DIRECTORY').$filename;
		$mimetype = mime_content_type($filepath);
		header('content-type: '.$mimetype);
		echo readfile($filepath);

	} else {

		http_response_code(404);
		die();
	}

} elseif(substr($path, 0, strlen("/rest/admin/")) === "/rest/admin/") {

	if (!$authorizer->verifyToken('admin')) {
		error_log("Token not valid");
		$router->redirect("/");
	}

	if(substr($path, 0, strlen("/rest/admin/ticket-templates")) === "/rest/admin/ticket-templates") {
		
		require_once './ws/ticket-template.php';
		bootstrap(function ($context) {
			echo (new TicketTemplateResource($context))->process();
		});
	
	} else if(substr($path, 0, strlen("/rest/admin/ticket-positions")) === "/rest/admin/ticket-positions") {

        require_once './ws/ticket-position.php';
        bootstrap(function ($context) {
            echo (new TicketPositionResource($context))->process();
        });

    } else if(substr($path, 0, strlen("/rest/admin/tickets")) === "/rest/admin/tickets") {

        require_once './ws/ticket.php';
        bootstrap(function ($context) {
            echo (new TicketResource($context))->process();
        });

    } else if(substr($path, 0, strlen("/rest/admin/tour-operators")) === "/rest/admin/tour-operators") {

        require_once './ws/tour-operator.php';
        bootstrap(function ($context) {
            echo (new TouroperatorResource($context))->process();
        });

    } else if(substr($path, 0, strlen("/rest/admin/tour-positions")) === "/rest/admin/tour-positions") {

        require_once './ws/tour-position.php';
        bootstrap(function ($context) {
            echo (new TourpositionResource($context))->process();
        });

    } else if(substr($path, 0, strlen("/rest/admin/tours")) === "/rest/admin/tours") {

        require_once './ws/tour.php';
        bootstrap(function ($context) {
            echo (new TourResource($context))->process();
        });

    } else {
		http_response_code(404);
		die();
	}

} else {
	http_response_code(404);
	die();
}
?>