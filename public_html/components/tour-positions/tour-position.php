<?php
namespace CTI;

require_once './i18n/i18n.php';
require_once './components/page.php';
require_once './repository/tour-position.php';
require_once './components/crud_mode.php';
require_once './model/message.php';

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

        try {
            $this->context->tourpositionValidator()->validate($entity);
            $this->context->tourPositionRepository()->update($entity);
            $this->context->messageService()->add(Message::success(Texts::tourposition_updated));
            $this->state = new TourpositionDetailState($entity, CrudMode::edit());
        } catch(\Exception $ex) {
            $messages = $this->context->exceptionMapper()->getMessages($ex);
            $this->context->messageService()->addAll($messages);
            $this->state = new TourpositionDetailState($entity, CrudMode::edit());
        }
    }

    private function processCreate() {
        $entity = new TourPosition(NULL, $_POST['description'], $_POST['code']);

        try {
            $this->context->tourpositionValidator()->validate($entity);
            $id = $this->context->tourPositionRepository()->create($entity);
            $this->context->router()->redirect('/admin/tour-position/'.$id);
        } catch(\Exception $ex) {
            $messages = $this->context->exceptionMapper()->getMessages($ex);
            $this->context->messageService()->addAll($messages);
            $this->state = new TourpositionDetailState($entity, CrudMode::create());
        }
    }
    
    private function processDelete() {
        $id = $this->getId();
        if ($id) {
            $this->findById($id); // Check that entity exists
            try {
                $this->context->tourPositionRepository()->delete($id);
            } catch(\PDOException $e) {
                // TODO: cleanup
                echo "EXCEPTION PDO: ";
                var_dump($e);
            }
        } else {
            $this->context->router()->notFound();
        }
    }
	
	public function template() : string {
		return 'tour-positions/tour-position.html';
	}
	
	public function context() : array {
		return [
            'state' => $this->state
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
    public $entity;
    public $mode;

    function __construct($entity, $mode) {
        $this->entity = $entity;
        $this->mode = $mode;
    }
}
?>