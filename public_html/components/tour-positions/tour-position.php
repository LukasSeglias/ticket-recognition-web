<?php
namespace CTI;

require_once './components/page.php';
require_once './repository/tour-position.php';
require_once './components/crud_mode.php';

class TourpositionDetailPage implements Page {
    private $context;
	private $state;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $this->getId();
            $mode;
            if ($id) {
                $entity = $this->context->tourPositionRepository()->get($id);
                $mode = CrudMode::edit();
            } else {
                $entity = new TourPosition(NULL, NULL, NULL);
                $mode = CrudMode::create();
            }
			$this->state = new TourpositionDetailState($entity, $mode);
		} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->getId();
            $entity = new TourPosition($id, $_POST['description'], $_POST['code']);
            $mode;
            if ($id) {
                $this->context->tourPositionRepository()->update($entity);
                $mode = CrudMode::edit();
            } else {
                $id = $this->context->tourPositionRepository()->create($entity);
                // FIXME: Use path param
                header('Location: /admin/tour-position.php?id='.$id);
                $mode = CrudMode::create();
            }
            $this->state = new TourpositionDetailState($entity, $mode);
		} elseif($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $id = $this->getId();
            if ($id) {
                $this->context->tourPositionRepository()->delete($id);
            }
            $this->state = new TourpositionDetailState(NULL, CrudMode::view());
        } else {
            $this->state = new TourpositionDetailState(NULL, CrudMode::view());
        }
	}
	
	public function template() : string {
		return 'tour-positions/tour-position.html';
	}
	
	public function context() : array {
		return [
			'entity' => $this->state->entity(),
            'mode' => $this->state->mode()
		];
	}

    private function getId() {
        // FIXME: Use path param
        //$url = explode('/', getenv('REQUEST_URI'));
        //return end($url);
        return $_GET['id'];
    }
}

class TourpositionDetailState {
    private $entity;
    private $mode;

    function __construct($entity, $mode) {
        $this->entity = $entity;
        $this->mode = $mode;
    }

    public function entity() {
        return $this->entity;
    }

    public function mode() {
        return $this->mode;
    }
}
?>