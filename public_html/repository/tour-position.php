<?php
namespace CTI;
    
require_once './model/tour-position.php';

class TourPositionRepository {
	
	private $databaseService;

	function __construct($databaseService) {
		$this->databaseService = $databaseService;
	}

    public function findBy($description, $code) {
        $builder = new QueryBuilder;
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
	
	private function map($row) : TourPosition {
		return new TourPosition(
			$row['ID'], $row['DESCRIPTION'], $row['CODE']
		);
	}

}

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