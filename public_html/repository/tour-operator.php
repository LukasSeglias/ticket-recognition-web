<?php
namespace CTI;

require_once './model/tour-operator.php';

class TouroperatorRepository {
	
	private $databaseService; 

	function __construct($databaseService) {
		$this->databaseService = $databaseService;
	}
	
	public function findById($id) {
		$statement = $this->databaseService->pdo()->prepare("SELECT * FROM tour_operator where id = :id");
		$statement->execute(array(':id' => $id));
		while($row = $statement->fetch()) {
			return $this->map($row);
		}
		return NULL;
	}

	public function findAll() : Array {
		$statement = $this->databaseService->pdo()->prepare("SELECT * FROM tour_operator");
		$statement->execute(array());
		$results = array();
		while($row = $statement->fetch()) {
			$results[] = $this->map($row);
		}
		return $results;
	}

	private function map($row) : Touroperator {
		return new Touroperator($row['id'], $row['name']);
	}

}

?>