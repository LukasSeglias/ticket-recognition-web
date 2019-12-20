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
        $description = strip_tags($_POST['description']);
        $code = strip_tags($_POST['code']);
        $entity = new Tour($id, $description, $code, $oldEntity->tourpositions());

        try {
            $this->context->tourValidator()->validate($entity);
            $this->context->tourRepository()->update($entity);
            $this->context->messageService()->add(Message::success(Texts::tour_updated));
            $this->state = new TourDetailState($entity, CrudMode::edit());
        } catch(\Exception $ex) {
            $messages = $this->context->exceptionMapper()->getMessages($ex);
            $this->context->messageService()->addAll($messages);
            $this->state = new TourDetailState($entity, CrudMode::edit());
        }
    }

    private function processCreate() {
        $description = strip_tags($_POST['description']);
        $code = strip_tags($_POST['code']);
        $entity = new Tour(NULL, $description, $code, array());

        try {
            $this->context->tourValidator()->validate($entity);
            $id = $this->context->tourRepository()->create($entity);
            $this->context->router()->redirect('/admin/tour/'.$id);
        } catch(\Exception $ex) {
            $messages = $this->context->exceptionMapper()->getMessages($ex);
            $this->context->messageService()->addAll($messages);
            $this->state = new TourDetailState($entity, CrudMode::create());
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