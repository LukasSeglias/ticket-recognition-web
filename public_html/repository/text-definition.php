<?php
namespace CTI;

require_once './model/text-definition.php';

class TextDefinitionRepository {
	
	private $databaseService;

	function __construct($databaseService) {
		$this->databaseService = $databaseService;
	}
	
	public function findByTemplateId($templateId) : Array {
		$statement = $this->databaseService->pdo()->prepare("SELECT * FROM text_definition where ticket_template_id = :templateId");
		$statement->execute(array(':templateId' => $templateId));
		$results = array();
		while($row = $statement->fetch()) {
			$results[] = $this->map($row);
		}
		return $results;
	}

	private function map($row) : TextDefinition {
		return new TextDefinition(
			$row['id'], $row['key'], $row['ticket_template_id'], $row['description'], 
			new Rectangle($row['x'], $row['y'], $row['width'], $row['height'])
		);
	}

}

?>