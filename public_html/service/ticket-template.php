<?php
namespace CTI;

require_once './model/ticket-template.php';

class TicketTemplateService {
	
	private $repository; 

	function __construct($repository) {
		$this->repository = $repository;
	}

	public function findBy($key) {
		return $this->repository->findBy($key);
	}

	public function findById($id) {
		return $this->repository->findById($id);
	}
	
	public function findAll() : Array {
		return $this->repository->findAll();
	}

	public function delete($id) {
		return $this->repository->delete($id);
	}

	public function create($entity) {
		return $this->repository->create($entity);
	}

	public function update($entity) {
		return $this->repository->update($entity);
	}

}

?>