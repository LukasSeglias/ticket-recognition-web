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

	public function findBy($key) {
        $builder = new TicketTemplate\QueryBuilder;
        $query = $builder->setKey($key)
                     ->build();
        $statement = $this->databaseService->pdo()->prepare($query);
		$statement->execute($builder->mapping());
        $results = array();
		while($row = $statement->fetch()) {
			$results[] = $this->map($row);
		}
		return $results;
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

	public function delete($id) {
		$pdo = $this->databaseService->pdo();
		try {
			$pdo->beginTransaction();

			$pdo->prepare("DELETE FROM text_definition where ticket_template_id = :id")->execute(array(":id" => $id));
			$pdo->prepare("DELETE FROM ticket_template where id = :id")->execute(array(":id" => $id));
		
			$pdo->commit();
		} 
		catch (\Exception $e) {
			if ($pdo->inTransaction()) {
				$pdo->rollback();
			}
			throw $e;
		}
	}

	public function create($entity) {
		$pdo = $this->databaseService->pdo();

		$statement = $pdo->prepare("INSERT INTO ticket_template(key, image_file_extension, tour_operator_id) VALUES(:key, :imageFileExtension, :tourOperatorId) RETURNING id");
		$statement->execute(array(
			':key' => $entity->key(), 
			':imageFileExtension' => $entity->imageFileExtension(),
			':tourOperatorId' => $entity->touroperator()->id())
		);
		$id = NULL;
		if ($row = $statement->fetch()) {
			$id = $row['id'];
		}

		if($id) {
			$this->insertTextDefinitions($pdo, $id, $entity->textDefinitions());
			return $id;
		}
		return -1;
	}

	public function update($entity) {
		$pdo = $this->databaseService->pdo();
		try {
			$pdo->beginTransaction();

			$pdo->prepare("DELETE FROM text_definition where ticket_template_id = :ticketTemplateId")->execute(array(":ticketTemplateId" => $entity->id()));
			$updateStatement = $pdo->prepare("UPDATE ticket_template SET key = :key, image_file_extension = :imageFileExtension, tour_operator_id = :tourOperatorId where id = :id");
			$updateStatement->execute(array(
				":id" => $entity->id(), 
				':key' => $entity->key(), 
				':imageFileExtension' => $entity->imageFileExtension(),
				':tourOperatorId' => $entity->touroperator()->id())
			);
			$this->insertTextDefinitions($pdo, $entity->id(), $entity->textDefinitions());
		
			$pdo->commit();
		} 
		catch (\Exception $e) {
			if ($pdo->inTransaction()) {
				$pdo->rollback();
			}
			throw $e;
		}
	}

	private function insertTextDefinitions($pdo, $ticketTemplateId, $textDefinitions) {
		foreach($textDefinitions as &$textDefinition) {
			$statement = $pdo->prepare("INSERT INTO text_definition(ticket_template_id, key, description, x, y, width, height) VALUES (:ticketTemplateId, :key, :description, :x, :y, :width, :height)");
			$statement->execute(array(
				":ticketTemplateId" => $ticketTemplateId, 
				':key' => $textDefinition->key(), 
				':description' => $textDefinition->description(), 
				':x' => $textDefinition->rectangle()->x(), 
				':y' => $textDefinition->rectangle()->y(), 
				':width' => $textDefinition->rectangle()->width(),
				':height' => $textDefinition->rectangle()->height())
			);
		}
	}

	private function map($row) : TicketTemplate {
		$touroperator = $this->touroperatorRepository->findById($row['tour_operator_id']);
		$textDefinitions = $this->textDefinitionRepository->findByTemplateId($row['id']);
		return new TicketTemplate($row['id'], $row['key'], $touroperator, $textDefinitions, $row['image_file_extension']);
	}

}


namespace CTI\TicketTemplate;

class QueryBuilder {
    private $mapping = array();

    public function setKey($key) : QueryBuilder {
        if (!$this->isNullOrEmpty($key)) {
            $this->mapping[':key'] = '%'.$key.'%';
        }
        return $this;
    }

    public function mapping() {
        return $this->mapping;
    }

    public function build() {
        $query = 'SELECT * FROM TICKET_TEMPLATE';
        $and = 'WHERE';

        if (array_key_exists(':key', $this->mapping)) {
            $query .= ' ' . $and . ' KEY like :key';
            $and = 'AND';
		}

        return $query;
    }

    function isNullOrEmpty($str){
        return (!isset($str) || trim($str) === '');
    }
}
?>