<?php
namespace CTI;

class Context {

	private $router;
	private $authService;
	private $ticketService;
	private $databaseService;
	private $messageService;

	private $textDefinitionRepository;
	
	private $touroperatorRepository;
	private $touroperatorValidator;

	private $tourPositionRepository;
	private $tourpositionValidator;

	private $ticketTemplateRepository;
	private $ticketTemplateService;
	private $ticketTemplateJsonMapper;
	private $ticketTemplateResource;
	private $ticketTemplateImageRepository;

	function __construct($router, $authService, $ticketService, $databaseService, 
		$messageService,
		$textDefinitionRepository, 
		$touroperatorRepository, 
		$touroperatorValidator,
		$ticketTemplateRepository,
		$tourPositionRepository,
		$tourpositionValidator,
		$ticketTemplateService,
		$ticketTemplateJsonMapper,
		$ticketTemplateResource,
		$ticketTemplateImageRepository,
		$exceptionMapper) {
			
		$this->router = $router;
		$this->authService = $authService;
		$this->ticketService = $ticketService;
		$this->databaseService = $databaseService;
		$this->messageService = $messageService;

		$this->textDefinitionRepository = $textDefinitionRepository;
		$this->touroperatorRepository = $touroperatorRepository;
		$this->touroperatorValidator = $touroperatorValidator;

		$this->ticketTemplateRepository = $ticketTemplateRepository;
		$this->tourPositionRepository = $tourPositionRepository;
		$this->tourpositionValidator = $tourpositionValidator;
		$this->ticketTemplateService = $ticketTemplateService;
		$this->ticketTemplateJsonMapper = $ticketTemplateJsonMapper;
		$this->ticketTemplateResource = $ticketTemplateResource;
		$this->ticketTemplateImageRepository = $ticketTemplateImageRepository;

		$this->exceptionMapper = $exceptionMapper;
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

	function tourpositionValidator() {
		return $this->tourpositionValidator;
	}

	function touroperatorValidator() {
		return $this->touroperatorValidator;
	}

	function messageService() {
		return $this->messageService;
	}

	function exceptionMapper() {
		return $this->exceptionMapper;
	}
}
?>