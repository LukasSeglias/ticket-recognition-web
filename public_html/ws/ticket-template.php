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

			if($_SERVER['REQUEST_METHOD'] === 'GET') {
				// Get
				$template = $this->findById($id);
				return $this->mapper->toJson($template);

			} elseif($_SERVER['REQUEST_METHOD'] === 'POST') {
				// Update
				$filename = $this->saveTemplateImage($id);

				// TODO: implement

				return;

			} elseif($_SERVER['REQUEST_METHOD'] === 'DELETE') {
				// Delete

				// TODO: implement
			}
		} else {

			if($_SERVER['REQUEST_METHOD'] === 'POST') {
				// Create
				$filename = $this->saveTemplateImage($id);

				// TODO: implement

				return;
			}

		}
		$this->router->notFound();
	}

	private function saveTemplateImage($id) {
		$uploadedFile = $_FILES['templateImage'];
		$extension = pathinfo($uploadedFile['name'])['extension'];
		$filename = $id.".".$extension;
		move_uploaded_file($uploadedFile['tmp_name'], getenv('CTI_IMAGE_DIRECTORY').$filename);
		return $filename;
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