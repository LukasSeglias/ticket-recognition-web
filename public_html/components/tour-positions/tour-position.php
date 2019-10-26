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
            
            $this->processView();

		} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $this->processSave();

		} elseif($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            
            $this->processDelete();

        } else {

            $this->context->router()->notFound();
        }
    }

    private function processView() {
        $id = $this->getId();
        if ($id) {
            $entity = $this->findById($id);
        } else {
            $entity = new TourPosition(NULL, NULL, NULL);
        }
        $mode = $id ? CrudMode::edit() : CrudMode::create();
        $this->state = new TourpositionDetailState($entity, $mode);
    }

    private function processSave() {
        $id = $this->getId();
        if ($id) {
            $this->processEdit($id);
        } else {
            $this->processCreate();
        }
    }

    private function processEdit($id) {
        $this->findById($id); // Check existence
        $entity = new TourPosition($id, $_POST['description'], $_POST['code']);
        // TODO: validation
        $this->context->tourPositionRepository()->update($entity);
        $this->state = new TourpositionDetailState($entity, CrudMode::edit());
    }

    private function processCreate() {
        $entity = new TourPosition(NULL, $_POST['description'], $_POST['code']);
        // TODO: validation
        $id = $this->context->tourPositionRepository()->create($entity);
        $this->context->router()->redirect('/admin/tour-position/'.$id);
    }
    
    private function processDelete() {
        $id = $this->getId();
        if ($id) {
            $this->findById($id); // Check that entity exists
            $this->context->tourPositionRepository()->delete($id);
            $this->context->router()->redirect('/admin/tour-positions');
        } else {
            $this->context->router()->notFound();
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
    
    private function findById($id) {
        $entity = $this->context->tourPositionRepository()->get($id);
        if($entity) {
            return $entity;
        }
        $this->context->router()->notFound();
    }

    private function getId() {
        $id = end(explode('/', getenv('REQUEST_URI')));
        return $id === 'tour-position' ? NULL : $id;
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