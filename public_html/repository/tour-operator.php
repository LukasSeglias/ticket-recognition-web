<?php
namespace CTI;

require_once './model/tour-operator.php';

class TouroperatorRepository {
	
	private $databaseService; 

	function __construct($databaseService) {
		$this->databaseService = $databaseService;
	}

	public function findBy($name) {
        $builder = new Touroperator\QueryBuilder;
        $query = $builder->setName($name)
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

	public function create($entity) {
        $statement = $this->databaseService->pdo()->prepare('INSERT INTO tour_operator (NAME) VALUES (:name) RETURNING id');
		$statement->execute([':name' => $entity->name()]);
        if ($row = $statement->fetch()) {
            return $row['id'];
        }
        return -1;
    }

    public function update($entity) {
        $statement = $this->databaseService->pdo()->prepare('UPDATE tour_operator SET NAME = :name WHERE id = :id');
		$statement->execute([':id' => $entity->id(),':name' => $entity->name()]);
    }

    public function delete($id) {
        $statement = $this->databaseService->pdo()->prepare('DELETE FROM tour_operator WHERE id = :id');
		$statement->execute([':id' => $id]);
    }

	private function map($row) : Touroperator {
		return new Touroperator($row['id'], $row['name']);
	}

}

namespace CTI\Touroperator;

class QueryBuilder {
    private $mapping = array();

    public function setName($name) : QueryBuilder {
        if (!$this->isNullOrEmpty($name)) {
            $this->mapping[':name'] = '%'.$name.'%';
        }
        return $this;
    }

    public function mapping() {
        return $this->mapping;
    }

    public function build() {
        $query = 'SELECT * FROM TOUR_OPERATOR';
        $and = 'WHERE';

        if (array_key_exists(':name', $this->mapping)) {
            $query .= ' ' . $and . ' NAME like :name';
            $and = 'AND';
        }

        return $query;
    }

    function isNullOrEmpty($str){
        return (!isset($str) || trim($str) === '');
    }
}
?>