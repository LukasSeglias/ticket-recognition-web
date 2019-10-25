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

	public function process() {

		$id = $this->getId();
		if($id) {
			$template = $this->findById($id);
			return $this->mapper->toJson($template);
		}
		http_response_code(404);
		die();
	}

	private function findById($id) {
		
		$template = $this->service->findById($id);
		if($template === NULL) {
			http_response_code(404);
			die();
		}
		return $template;
	}

	private function getId() : string {
		$pathSegments = explode('/', strtok(getenv('REQUEST_URI'), '?'));
		return $pathSegments[count($pathSegments) - 1];
	}

}
?>