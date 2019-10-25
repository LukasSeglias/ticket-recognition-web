<?php
namespace CTI;

require_once './model/text-definition.php';

class TextDefinitionRepository {
	
	private $databaseService;

	function __construct($databaseService) {
		$this->databaseService = $databaseService;
	}
	
	public function findByTemplateId($templateId) : Array {
		$statement = $this->databaseService->pdo()->prepare("SELECT * FROM TEXT_DEFINITION where TICKET_TEMPLATE_ID = :templateId");
		$statement->execute(array(':templateId' => $templateId));
		$results = array();
		while($row = $statement->fetch()) {
			$results[] = $this->map($row);
		}
		return $results;
	}

	private function map($row) : TextDefinition {
		return new TextDefinition(
			$row['ID'], $row['KEY'], $row['TICKET_TEMPLATE_ID'], $row['DESCRIPTION'], 
			new Rectangle($row['X'], $row['Y'], $row['WIDTH'], $row['HEIGHT'])
		);
	}

}

?>