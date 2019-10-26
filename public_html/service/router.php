<?php
namespace CTI;

class Router {

	function redirect(string $location) {
		header('Location: ' . $location);
		die();
	}

	function notFound() {
		http_response_code(404);
		die();
	}
}
?>