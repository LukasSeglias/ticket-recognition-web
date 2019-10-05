<?php
namespace CTI;

class Context {

	private $router;
	private $authService;
	private $ticketService;

	function __construct($router, $authService, $ticketService) {
		$this->router = $router;
		$this->authService = $authService;
		$this->ticketService = $ticketService;
	}

	function router() {
		return $this->router;
	}

	function authService() {
		return $this->authService;
	}

	function ticketService() {
		return $this->ticketService;
	}
}
?>