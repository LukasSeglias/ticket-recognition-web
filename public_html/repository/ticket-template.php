<?php
namespace CTI;

require_once './model/ticket-template.php';

class TicketTemplateRepository {
	
	private $databaseService;
	private $textDefinitionRepository;
	private $touroperatorRepository;

	function __construct($databaseService, $textDefinitionRepository, $touroperatorRepository) {
		$this->databaseService = $databaseService;
		$this->textDefinitionRepository = $textDefinitionRepository;
		$this->touroperatorRepository = $touroperatorRepository;
	}
	
	public function findById($id) {
		$statement = $this->databaseService->pdo()->prepare("SELECT * FROM ticket_template where id = :id");
		$statement->execute(array(':id' => $id));
		while($row = $statement->fetch()) {
			return $this->map($row);
		}
		return NULL;
	}

	public function findAll() : Array {
		$statement = $this->databaseService->pdo()->prepare("SELECT * FROM ticket_template");
		$statement->execute(array());
		$results = array();
		while($row = $statement->fetch()) {
			$results[] = $this->map($row);
		}
		return $results;
	}

	private function map($row) : TicketTemplate {
		$touroperator = $this->touroperatorRepository->findById($row['tour_operator_id']);
		$textDefinitions = $this->textDefinitionRepository->findByTemplateId($row['id']);
		return new TicketTemplate($row['id'], $row['key'], $touroperator, $textDefinitions);
	}

}

?>