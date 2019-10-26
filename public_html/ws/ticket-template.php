<?php
namespace CTI;

require_once './service/router.php';
require_once './json/ticket-template.php';
require_once './service/ticket-template.php';

class TicketTemplateResource {

	private $router;
	private $service;
	private $mapper;

	function __construct(Router $router, TicketTemplateService $service, TicketTemplateJsonMapper $mapper) {
		$this->router = $router;
		$this->service = $service;
		$this->mapper = $mapper;
	}

	public function process() {

		$id = $this->getId();
		if($id) {
			$template = $this->findById($id);
			return $this->mapper->toJson($template);
		}
		$this->router->notFound();
	}

	private function findById($id) {
		
		$template = $this->service->findById($id);
		if($template === NULL) {
			$this->router->notFound();
		}
		return $template;
	}

	private function getId() : string {
		$url = explode('/', getenv('REQUEST_URI'));
        return end($url);
	}

}
?>