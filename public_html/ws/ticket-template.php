<?php
namespace CTI;

require_once './service/router.php';
require_once './json/ticket-template.php';
require_once './service/ticket-template.php';
require_once './io/ticket-template.php';

class TicketTemplateResource {

	private $router;
	private $service;
	private $mapper;
	private $imageRepository;

	function __construct(Router $router, TicketTemplateService $service, TicketTemplateJsonMapper $mapper, TicketTemplateImageRepository $imageRepository) {
		$this->router = $router;
		$this->service = $service;
		$this->mapper = $mapper;
		$this->imageRepository = $imageRepository;
	}

	public function process() {

		$id = $this->getId();
		if($id) {

			if($_SERVER['REQUEST_METHOD'] === 'GET') {
				
				return $this->get($id);

			} elseif($_SERVER['REQUEST_METHOD'] === 'POST') {

				return $this->update($id);

			} elseif($_SERVER['REQUEST_METHOD'] === 'DELETE') {
				// Delete

				// TODO: implement
			}
		} else {

			if($_SERVER['REQUEST_METHOD'] === 'POST') {
				
				return $this->create();
			}

		}
		$this->router->notFound();
	}

	private function get($id) {
		$template = $this->findById($id);
		return $this->mapper->toJson($template);
	}

	private function create($id) {

		$uploadedFile = $_FILES['templateImage'];
		$fileExtension = $this->imageRepository->getFileExtension($uploadedFile);

		$jsonString = $_POST['template'];
		$entity = $this->mapper->fromJsonObject($jsonString);
		$entity = new TicketTemplate(NULL, $entity->key(), $entity->touroperator(), $entity->textDefinitions(), $fileExtension);		

		// TODO: validation

		$id = $this->service->create($entity);
		$this->imageRepository->create($entity, $uploadedFile);
		
		var_dump($entity);

		// TODO: implement

		// TODO: return id?
	}

	private function update($id) {

		$uploadedFile = $_FILES['templateImage'];
		$fileExtension = $this->imageRepository->getFileExtension($uploadedFile);

		$oldEntity = $this->findById($id);

		$jsonString = $_POST['template'];
		$entity = $this->mapper->fromJsonObject($jsonString);
		$entity = new TicketTemplate($id, $entity->key(), $entity->touroperator(), $entity->textDefinitions(), $fileExtension);

		// TODO: validation

		$this->service->update($entity);
		$this->imageRepository->update($entity, $oldEntity, $uploadedFile);

		var_dump($entity);

		// TODO: implement

		return;
	}

	private function delete($id) {

		$entity = $this->findById($id);

		// TODO: validation

		$this->service->delete($entity);
		$this->imageRepository->delete($entity);
	}

	private function saveTemplateImage($id, $fileExtension) {
		$uploadedFile = $_FILES['templateImage'];
		$filename = $this->getTemplateFilename($id, $fileExtension);
		move_uploaded_file($uploadedFile['tmp_name'], getenv('CTI_IMAGE_DIRECTORY').$filename);
	}

	private function getTemplateFilename($id, $fileExtension) {
		return $id.".".$fileExtension;
	}

	private function getTemplateImageFileExtension() {
		$uploadedFile = $_FILES['templateImage'];
		return pathinfo($uploadedFile['name'])['extension'];
	}

	private function getTemplateImageFilePath($filename) {
		return getenv('CTI_IMAGE_DIRECTORY').$filename;
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