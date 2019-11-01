<?php
namespace CTI;

class Context {

	private $router;
	private $authService;
	private $ticketService;
	private $databaseService;
	private $textDefinitionRepository;
	private $touroperatorRepository;
	private $tourPositionRepository;

	private $ticketTemplateRepository;
	private $ticketTemplateService;
	private $ticketTemplateJsonMapper;
	private $ticketTemplateResource;
	private $ticketTemplateImageRepository;

	function __construct($router, $authService, $ticketService, $databaseService, 
		$textDefinitionRepository, $touroperatorRepository, $ticketTemplateRepository,
		$tourPositionRepository,
		$ticketTemplateService,
		$ticketTemplateJsonMapper,
		$ticketTemplateResource,
		$ticketTemplateImageRepository) {
			
		$this->router = $router;
		$this->authService = $authService;
		$this->ticketService = $ticketService;
		$this->databaseService = $databaseService;
		$this->textDefinitionRepository = $textDefinitionRepository;
		$this->touroperatorRepository = $touroperatorRepository;

		$this->ticketTemplateRepository = $ticketTemplateRepository;
		$this->tourPositionRepository = $tourPositionRepository;
		$this->ticketTemplateService = $ticketTemplateService;
		$this->ticketTemplateJsonMapper = $ticketTemplateJsonMapper;
		$this->ticketTemplateResource = $ticketTemplateResource;
		$this->ticketTemplateImageRepository = $ticketTemplateImageRepository;
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

	function ticketTemplateJsonMapper() {
		return $this->ticketTemplateJsonMapper;
	}

	function ticketTemplateResource() {
		return $this->ticketTemplateResource;
	}

	function ticketTemplateImageRepository() {
		return $this->ticketTemplateImageRepository;
	}
}
?>