<?php
namespace CTI;

require_once './i18n/i18n.php';
require_once './components/page.php';
require_once './repository/tour.php';
require_once './components/crud_mode.php';
require_once './model/message.php';

class TourDetailPage implements Page {
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
            $entity = new Tour(NULL, NULL, NULL, array());
        }
        $mode = $id ? CrudMode::edit() : CrudMode::create();
        $this->state = new TourDetailState($entity, $mode);
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
        $oldEntity = $this->findById($id); // Check existence
        $entity = new Tour($id, $_POST['description'], $_POST['code'], $oldEntity->tourpositions());

        $validation = $this->context->tourValidator()->validate($entity);
        if($validation->hasErrors()) {

            $this->state = new TourDetailState($entity, CrudMode::edit());
        } else {

            try {
                $this->context->tourRepository()->update($entity);
                $this->context->messageService()->add(Message::success(Texts::tour_updated));
                $this->state = new TourDetailState($entity, CrudMode::edit());
            } catch(\PDOException $ex) {
                $messages = $this->context->exceptionMapper()->getMessages($ex);
                $this->context->messageService()->addAll($messages);
                $this->state = new TourDetailState($entity, CrudMode::edit());
            }
        }
    }

    private function processCreate() {
        $entity = new Tour(NULL, $_POST['description'], $_POST['code'], array());

        $validation = $this->context->tourValidator()->validate($entity);
        if($validation->hasErrors()) {
            
            $this->context->messageService()->addAll($validation->errors());
            $this->state = new TourDetailState($entity, CrudMode::create());
        } else {

            try {
                $id = $this->context->tourRepository()->create($entity);
                $this->context->router()->redirect('/admin/tour/'.$id);
            } catch(\PDOException $ex) {
                $messages = $this->context->exceptionMapper()->getMessages($ex);
                $this->context->messageService()->addAll($messages);
                $this->state = new TourDetailState($entity, CrudMode::create());
            }
        }
    }
    
    private function processDelete() {
        $id = $this->getId();
        if ($id) {
            $this->findById($id); // Check that entity exists
            try {
                $this->context->tourRepository()->delete($id);
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
		return 'tours/tour.html';
	}
	
	public function context() : array {
		return [
            'state' => $this->state
		];
    }
    
    private function findById($id) {
        $entity = $this->context->tourRepository()->findById($id);
        if($entity) {
            return $entity;
        }
        $this->context->router()->notFound();
    }

    private function getId() {
        $id = end(explode('/', getenv('REQUEST_URI')));
        return $id === 'tour' ? NULL : $id;
    }
}

class TourDetailState {
    public $entity;
    public $mode;

    function __construct($entity, $mode) {
        $this->entity = $entity;
        $this->mode = $mode;
    }
}
?>