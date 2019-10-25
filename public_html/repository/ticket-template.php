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
	
	public function findById($id) : TicketTemplate {
		$statement = $this->databaseService->pdo()->prepare("SELECT * FROM TICKET_TEMPLATE where ID = :id");
		$statement->execute(array(':id' => $id));
		while($row = $statement->fetch()) {
			return $this->map($row);
		}
		return NULL;
	}

	public function findAll() : Array {
		$statement = $this->databaseService->pdo()->prepare("SELECT * FROM TICKET_TEMPLATE");
		$statement->execute(array());
		$results = array();
		while($row = $statement->fetch()) {
			$results[] = $this->map($row);
		}
		return $results;
	}

	private function map($row) : TicketTemplate {
		$touroperator = $this->touroperatorRepository->findById($row['TOUR_OPERATOR_ID']);
		$textDefinitions = $this->textDefinitionRepository->findByTemplateId($row['ID']);
		return new TicketTemplate($row['ID'], $row['KEY'], $touroperator, $textDefinitions);
	}

}

?>