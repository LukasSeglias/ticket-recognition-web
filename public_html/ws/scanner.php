<?php
namespace CTI;

require_once './service/router.php';
require_once './json/ticket-template.php';
require_once './service/ticket-template.php';
require_once './io/ticket-template.php';

class ScannerResource {

	private $context;
	private $service;
	private $mapper;

	function __construct($context) {
		$this->context = $context;
		$this->service = $context->scannerService();
		$this->mapper = $context->ticketTemplateJsonMapper();
	}

	public function process() {

		if($_SERVER['REQUEST_METHOD'] === 'POST') {

			return $this->update();

		}
		$this->context->router()->notFound();
	}

	private function create() {

		try {
			$uploadedFile = $_FILES['templateImage'];

			$result = $this->service->create();

			return $this->mapper->toJson($result);

        } catch(\Exception $ex) {
			$messages = $this->context->exceptionMapper()->getMessages($ex);
			http_response_code(400);
            return $this->context->messageJsonMapper()->toJson($messages);
        }
	}

}
?>