<?php
namespace CTI;

require_once './service/router.php';
require_once './json/ticket-template.php';
require_once './service/ticket-template.php';
require_once './io/ticket-template.php';
require_once './model/cti-point.php';
require_once './model/cti-template.php';
require_once './model/cti-text.php';

class TicketTemplateResource {

	private $context;
	private $service;
	private $mapper;
	private $imageRepository;

	function __construct($context) {
		$this->context = $context;
		$this->service = $context->ticketTemplateService();
		$this->mapper = $context->ticketTemplateJsonMapper();
		$this->imageRepository = $context->ticketTemplateImageRepository();
	}

	public function process() {

		$id = $this->getId();
		if($id) {

			if($_SERVER['REQUEST_METHOD'] === 'GET') {
				
				return $this->get($id);

			} elseif($_SERVER['REQUEST_METHOD'] === 'POST') {

				return $this->update($id);

			} elseif($_SERVER['REQUEST_METHOD'] === 'DELETE') {
				
				return $this->delete($id);
			}
		} else {

			if($_SERVER['REQUEST_METHOD'] === 'POST') {
				
				return $this->create();
			}

		}
		$this->context->router()->notFound();
	}

	private function get($id) {
		$template = $this->findById($id);
		return $this->mapper->toJson($template);
	}

	private function uploadTemplate($uploadedFileName, $entity, $fileExtension) {
	    $texts = [];
	    foreach ($entity->textDefinitions() as $textDefinition) {
	        $topLeft = new CtiPoint($textDefinition->rectangle()->x(), $textDefinition->rectangle()->y());
	        $bottomX = $topLeft->getX() + $textDefinition->rectangle()->width();
	        $bottomY = $topLeft->getY() + $textDefinition->rectangle()->height();
	        $bottomRight = new CtiPoint($bottomX, $bottomY);

	        $text = new CtiText($textDefinition->key(), $topLeft, $bottomRight);
	        array_push($texts, $text);
        }
	    $template = new CtiTemplate($entity->key(), $entity->id() . '.' . $fileExtension, $texts);

        $this->context->ctiService()->uploadTemplate($template, $uploadedFileName, $_COOKIE['ACCESS_TOKEN']);
    }

	private function create() {

		try {
			$uploadedFile = $_FILES['templateImage'];
			$fileExtension = $this->imageRepository->getFileExtension($uploadedFile);

			$jsonString = $_POST['template'];
			$entity = $this->mapper->fromJsonObject($jsonString);
			$entity = new TicketTemplate(NULL, $entity->key(), $entity->touroperator(), $entity->textDefinitions(), $fileExtension);		

			$this->context->ticketTemplateValidator()->validate($entity);

			$id = $this->service->create($entity);
			$entity = $this->findById($id);
            $this->uploadTemplate($uploadedFile['tmp_name'], $entity, $fileExtension);
			$this->imageRepository->create($entity, $uploadedFile);

			return $this->mapper->toJson($entity);

        } catch(\Exception $ex) {
			$messages = $this->context->exceptionMapper()->getMessages($ex);
			http_response_code(400);
            return $this->context->messageJsonMapper()->toJson($messages);
        }
	}

	private function update($id) {

		try {
			$uploadedFile = $_FILES['templateImage'];
			$fileExtension = $this->imageRepository->getFileExtension($uploadedFile);

			$oldEntity = $this->findById($id);

			$jsonString = $_POST['template'];
			$entity = $this->mapper->fromJsonObject($jsonString);
			$entity = new TicketTemplate($id, $entity->key(), $entity->touroperator(), $entity->textDefinitions(), $fileExtension);

			$this->context->ticketTemplateValidator()->validate($entity);

			$this->service->update($entity);
            $this->uploadTemplate($uploadedFile['tmp_name'], $entity, $fileExtension);
			$this->imageRepository->update($entity, $oldEntity, $uploadedFile);

			return $this->mapper->toJson($entity);

		} catch(\Exception $ex) {
			$messages = $this->context->exceptionMapper()->getMessages($ex);
			http_response_code(400);
			return $this->context->messageJsonMapper()->toJson($messages);
		}
	}

	private function delete($id) {

		try {
			$entity = $this->findById($id);

			$this->service->delete($id);
			$this->imageRepository->delete($entity);

        } catch(\Exception $ex) {
			$messages = $this->context->exceptionMapper()->getMessages($ex);
			http_response_code(400);
            return $this->context->messageJsonMapper()->toJson($messages);
        }
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
			$this->context->router()->notFound();
		}
		return $template;
	}

	private function getId() {
        $id = end(explode('/', getenv('REQUEST_URI')));
        return $id === 'ticket-templates' ? NULL : $id;
    }

}
?>