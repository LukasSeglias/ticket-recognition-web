<?php
namespace CTI;

class Context {

	private $router;
	private $authService;
	private $databaseService;
	private $messageService;

	private $textDefinitionRepository;
	private $tourRepository;
	private $tourValidator;
	
	private $touroperatorRepository;
	private $touroperatorValidator;

	private $tourPositionRepository;
	private $tourpositionValidator;

	private $messageJsonMapper;

	private $ticketTemplateValidator;
	private $ticketTemplateRepository;
	private $ticketTemplateService;
	private $ticketTemplateJsonMapper;
	private $ticketTemplateImageRepository;

	private $ticketRepository;
	private $ticketPositionRepository;
	private $ticketValidator;

	function __construct($router, $authService, $databaseService, 
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
		$exceptionMapper) {
			
		$this->router = $router;
		$this->authService = $authService;
		$this->databaseService = $databaseService;
		$this->messageService = $messageService;

		$this->textDefinitionRepository = $textDefinitionRepository;
		$this->tourRepository = $tourRepository;
		$this->tourValidator = $tourValidator;
		$this->touroperatorRepository = $touroperatorRepository;
		$this->touroperatorValidator = $touroperatorValidator;

		$this->ticketTemplateRepository = $ticketTemplateRepository;
		$this->messageJsonMapper = $messageJsonMapper;
		$this->tourPositionRepository = $tourPositionRepository;
		$this->tourpositionValidator = $tourpositionValidator;

		$this->ticketTemplateValidator = $ticketTemplateValidator;
		$this->ticketTemplateService = $ticketTemplateService;
		$this->ticketTemplateJsonMapper = $ticketTemplateJsonMapper;
		$this->ticketTemplateImageRepository = $ticketTemplateImageRepository;

		$this->ticketRepository = $ticketRepository;
        $this->ticketPositionRepository = $ticketPositionRepository;
        $this->ticketValidator = $ticketValidator;

		$this->exceptionMapper = $exceptionMapper;
	}

	function router() {
		return $this->router;
	}

	function authService() {
		return $this->authService;
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

	function tourRepository() {
		return $this->tourRepository;
	}

	function tourValidator() {
		return $this->tourValidator;
	}

	function messageJsonMapper() {
		return $this->messageJsonMapper;
	}

	function ticketTemplateValidator() {
		return $this->ticketTemplateValidator;
	}

	function ticketRepository() {
	    return $this->ticketRepository;
    }

    function ticketPositionRepository() {
	    return $this->ticketPositionRepository;
    }

    function ticketValidator() {
	    return $this->ticketValidator;
    }
}
?>