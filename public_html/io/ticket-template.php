<?php
namespace CTI;

require_once './service/router.php';
require_once './json/ticket-template.php';
require_once './service/ticket-template.php';

class TicketTemplateImageRepository {

	function __construct() {
		
	}

	public function create($entity, $uploadedFile) {
		move_uploaded_file($uploadedFile['tmp_name'], $this->getFilePath($entity));
	}

	public function update($entity, $oldEntity, $uploadedFile) {
		$oldFilePath = $this->getFilePath($oldEntity);

		if(file_exists($oldFilePath)) {
			unlink($oldFilePath);
		}
		move_uploaded_file($uploadedFile['tmp_name'], $this->getFilePath($entity));
	}

	public function delete($entity) {
		unlink($this->getFilePath($entity));
	}

	public function getFileExtension($file) {
		return pathinfo($file['name'])['extension'];
	}

	private function getFilename($entity) {
		if(is_null($entity->id()) || empty($entity->imageFileExtension())) {
			throw new \Exception('Invalid ticket template, cannot create filename');
		}
		return $entity->id().".".$entity->imageFileExtension();
	}

	private function getFilePath($entity) {
		$basePath = getenv('CTI_IMAGE_DIRECTORY');
		$filePath = $basePath.$this->getFilename($entity);

		// Handle possibly invalid paths that resolve into a different directory than $basePath
		if (substr($filePath, 0, strlen($basePath)) !== $basePath) {
			throw new \Exception('Invalid ticket template filepath');
		}
		return $filePath;
	}

}
?>