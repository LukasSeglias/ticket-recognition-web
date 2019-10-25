<?php
namespace CTI;

class Context {

	private $router;
	private $authService;
	private $ticketService;
	private $databaseService;
	private $textDefinitionRepository;
	private $touroperatorRepository;
	private $ticketTemplateRepository;
	private $tourPositionRepository;

	function __construct($router, $authService, $ticketService, $databaseService, 
		$textDefinitionRepository, $touroperatorRepository, $ticketTemplateRepository,
		$tourPositionRepository, $ticketTemplateService) {
		$this->router = $router;
		$this->authService = $authService;
		$this->ticketService = $ticketService;
		$this->databaseService = $databaseService;
		$this->textDefinitionRepository = $textDefinitionRepository;
		$this->touroperatorRepository = $touroperatorRepository;
		$this->ticketTemplateRepository = $ticketTemplateRepository;
		$this->tourPositionRepository = $tourPositionRepository;
		$this->ticketTemplateService = $ticketTemplateService;
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

	function textDefinitionRepository() {
		return $this->textDefinitionRepository;
	}

	function touroperatorRepository() {
		return $this->touroperatorRepository;
	}

	function ticketTemplateRepository() {
		return $this->ticketTemplateRepository;
	}

	function tourPositionRepository() {
		return $this->tourPositionRepository;
	}

	function ticketTemplateService() {
		return $this->ticketTemplateService;
	}
}
?>