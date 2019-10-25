<?php
namespace CTI;

require_once './model/ticket-template.php';

class TicketTemplateService {
	
	private $repository; 

	function __construct($repository) {
		$this->repository = $repository;
	}

	public function findById($id) {
		return $this->repository->findById($id);
	}
	
	public function findAll() : Array {
		return $this->repository->findAll();
	}

}

?>