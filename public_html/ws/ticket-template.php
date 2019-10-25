<?php
namespace CTI;

require_once './json/ticket-template.php';
require_once './service/ticket-template.php';

class TicketTemplateResource {

	private $service;
	private $mapper;

	function __construct(TicketTemplateService $service, TicketTemplateJsonMapper $mapper) {
		$this->service = $service;
		$this->mapper = $mapper;
	}

	public function process() : string {
		$templates = $this->service->findAll();
		return $this->mapper->toJson($templates);
	}

}
?>