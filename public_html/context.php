<?php
namespace CTI;

class Context {

	private $router;
	private $authService;
	private $ticketService;
	private $databaseService;

	function __construct($router, $authService, $ticketService, $databaseService) {
		$this->router = $router;
		$this->authService = $authService;
		$this->ticketService = $ticketService;
		$this->databaseService = $databaseService;
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

	function pdo() {
		return $this->databaseService->pdo();
	}
}
?>