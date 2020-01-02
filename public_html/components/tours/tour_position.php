<?php

namespace CTI;

class TourPositionPage implements Page {

    private $context;
    private $state;

    function __construct($context) {
        $this->context = $context;
    }

    public function update() {
        $id = $this->getId();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($id == NULL) {
                $this->context->router()->redirect("/admin/tours");
            }

            $positioncode = strip_tags($_POST['positioncode']);
            $filter = new TourPositionPageFilter($positioncode);
            $results = $this->loadResults($filter, $id);
            $this->state = new TourPositionPageState($results, $filter, $id);
        } else {
            $filter = new TourPositionPageFilter(NULL);
            $results = $this->loadResults($filter, $id);
            $this->state = new TourPositionPageState($results, new TourPositionPageFilter(NULL), $id);
        }
    }

    public function template() : string {
        return 'tours/tour_position.html';
    }

    public function context() : array {
        return [
            'state' => $this->state
        ];
    }

    private function loadResults(TourPositionPageFilter $filter, $id) : array {
        $allTourPositions = $this->context->tourPositionRepository()->findBy(NULL, $filter->code);
        $appliedTourPositions = $this->context->tourPositionRepository()->findByTourId($id);
        $results = array();

        foreach ($allTourPositions as $tourPosition) {
            $applied = NULL;
            foreach ($appliedTourPositions as $appliedPosition) {
                if ($tourPosition->code() === $appliedPosition->code()) {
                    $applied = $appliedPosition;
                    break;
                }
            }

            if ($applied !== NULL) {
                $value = new TourPositionListEntry($applied->id(), $applied->description(), $applied->code(), $id);
            } else {
                $value = new TourPositionListEntry($tourPosition->id(), $tourPosition->description(), $tourPosition->code(), NULL);
            }

            array_push($results, $value);
        }

        return $results;
    }

    private function getId() {
        $id = end(explode('/', getenv('REQUEST_URI')));
        return $id === 'tour-position' ? NULL : $id;
    }
}

class TourPositionPageState {
    public $items;
    public $filter;
    public $tourId;

    function __construct(array $items, TourPositionPageFilter $filter, $tourId) {
        $this->items = $items;
        $this->filter = $filter;
        $this->tourId = $tourId;
    }
}

class TourPositionPageFilter {
    public $code;

    function __construct($code) {
        $this->code = $code;
    }
}

class TourPositionListEntry {
	
	private $id;
	private $description;
    private $code;
    private $tourId;
	
	function __construct($id, $description, $code, $tourId) {
		$this->id = $id;
		$this->description = $description;
        $this->code = $code;
        $this->tourId = $tourId;
	}
	
	public function id() {
		return $this->id;
	}

	public function description() {
		return $this->description;
	}

	public function code() {
		return $this->code;
    }
    
    public function tourId() {
        return $this->tourId;
    }
	
}
?>