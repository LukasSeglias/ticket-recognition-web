<?php
namespace CTI;

require_once './model/tour.php';

class TourRepository {
	
    private $databaseService; 
    private $tourpositionRepository;

	function __construct($databaseService, $tourpositionRepository) {
        $this->databaseService = $databaseService;
        $this->tourpositionRepository = $tourpositionRepository;
	}

	public function findBy($code, $description) {
        $builder = new Tour\QueryBuilder;
        $code = is_numeric($code) ? $code : NULL;
        $query = $builder->setCode($code)
                    ->setDescription($description)
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
		$statement = $this->databaseService->pdo()->prepare("SELECT * FROM tour where id = :id");
		$statement->execute(array(':id' => $id));
		while($row = $statement->fetch()) {
			return $this->map($row);
		}
		return NULL;
	}

    public function findAll() : Array {
        $statement = $this->databaseService->pdo()->prepare("SELECT * FROM tour");
        $statement->execute(array());
        $results = array();
        while($row = $statement->fetch()) {
            $results[] = $this->map($row);
        }
        return $results;
    }

	public function create($entity) {
        $statement = $this->databaseService->pdo()->prepare('INSERT INTO tour (CODE, DESCRIPTION) VALUES (:code, :description) RETURNING id');
		$statement->execute([':code' => $entity->code(), ':description' => $entity->description()]);
        if ($row = $statement->fetch()) {
            return $row['id'];
        }
        return -1;
    }

    public function update($entity) {
        $statement = $this->databaseService->pdo()->prepare('UPDATE tour SET CODE = :code, DESCRIPTION = :description WHERE id = :id');
		$statement->execute([':id' => $entity->id(), ':code' => $entity->code(), ':description' => $entity->description()]);
    }

    public function delete($id) {
        $pdo = $this->databaseService->pdo();
		try {
			$pdo->beginTransaction();

			$pdo->prepare("DELETE FROM TOUR_TOUR_POSITION where TOUR_ID = :id")->execute(array(":id" => $id));
			$pdo->prepare("DELETE FROM TOUR where id = :id")->execute(array(":id" => $id));
		
			$pdo->commit();
		} 
		catch (\Exception $e) {
			if ($pdo->inTransaction()) {
				$pdo->rollback();
			}
			throw $e;
		}
    }

    public function addPosition($id, $positionId) {
        $statement = $this->databaseService->pdo()->prepare('INSERT INTO tour_tour_position (tour_id, tour_position_id) VALUES (:tourId,:tourPositionId)');
		$statement->execute([':tourId' => $id, ':tourPositionId' => $positionId]);
    }

    public function removePosition($id, $positionId) {
        $statement = $this->databaseService->pdo()->prepare('DELETE FROM tour_tour_position WHERE tour_id = :tourId and tour_position_id = :tourPositionId');
        $statement->execute([':tourId' => $id, ':tourPositionId' => $positionId]);
    }
    
    private function map($row) : Tour {
		$tourpositions = $this->tourpositionRepository->findByTourId($row['id']);
		return new Tour($row['id'], $row['description'], $row['code'], $tourpositions);
	}

}

namespace CTI\Tour;

class QueryBuilder {
    private $mapping = array();

    public function setCode($code) : QueryBuilder {
        if (!$this->isNullOrEmpty($code)) {
            $this->mapping[':code'] = $code;
        }
        return $this;
    }

    public function setDescription($description) : QueryBuilder {
        if (!$this->isNullOrEmpty($description)) {
            $this->mapping[':description'] = '%'.$description.'%';
        }
        return $this;
    }

    public function mapping() {
        return $this->mapping;
    }

    public function build() {
        $query = 'SELECT * FROM TOUR';
        $and = 'WHERE';

        if (array_key_exists(':code', $this->mapping)) {
            $query .= ' ' . $and . ' CODE = :code';
            $and = 'AND';
        }

        if (array_key_exists(':description', $this->mapping)) {
            $query .= ' ' . $and . ' DESCRIPTION like :description';
            $and = 'AND';
        }

        return $query;
    }

    function isNullOrEmpty($str){
        return (!isset($str) || trim($str) === '');
    }
}
?>