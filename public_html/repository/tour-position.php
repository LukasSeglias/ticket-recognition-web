<?php
namespace CTI;
    
require_once './model/tour-position.php';

class TourPositionRepository {
	
	private $databaseService;

	function __construct($databaseService) {
		$this->databaseService = $databaseService;
	}

    public function findBy($description, $code) {
        $builder = new Tourposition\QueryBuilder;
        $query = $builder->setDescription($description)
                     ->setCode($code)
                     ->build();
        $statement = $this->databaseService->pdo()->prepare($query);
		$statement->execute($builder->mapping());
        $results = array();
		while($row = $statement->fetch()) {
			$results[] = $this->map($row);
		}
		return $results;
    }

    public function get($id) {
        $statement = $this->databaseService->pdo()->prepare('SELECT * FROM tour_position WHERE id = :id');
		$statement->execute([':id' => $id]);
        $entity;
		if($row = $statement->fetch()) {
			$entity = $this->map($row);
		}
        return $entity;
    }

    public function findByTourId($tourId) : array {
        $statement = $this->databaseService->pdo()->prepare('SELECT * FROM tour_position AS tp JOIN tour_tour_position AS ttp ON tp.id = ttp.tour_position_id WHERE ttp.tour_id = :tourId');
		$statement->execute([':tourId' => $tourId]);
        $results = array();
		while($row = $statement->fetch()) {
			$results[] = $this->map($row);
		}
		return $results;
    }

    public function create($entity) {
        $statement = $this->databaseService->pdo()->prepare('INSERT INTO tour_position (description,code) VALUES (:description,:code) RETURNING id');
		$statement->execute([':description' => $entity->description(), ':code' => $entity->code()]);
        if ($row = $statement->fetch()) {
            return $row['id'];
        }
        return -1;
    }

    public function update($entity) {
        $statement = $this->databaseService->pdo()->prepare('UPDATE tour_position SET description = :description, code = :code WHERE id = :id');
		$statement->execute([':id' => $entity->id(),':description' => $entity->description(), ':code' => $entity->code()]);
    }

    public function delete($id) {
        $statement = $this->databaseService->pdo()->prepare('DELETE FROM tour_position WHERE id = :id');
		$statement->execute([':id' => $id]);
    }
	
	private function map($row) : TourPosition {
		return new TourPosition(
			$row['id'], $row['description'], $row['code']
		);
	}

}

namespace CTI\Tourposition;

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
        $query = 'SELECT * FROM TOUR_POSITION';
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