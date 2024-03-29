<?php
namespace CTI;

require_once './i18n/i18n.php';
require_once './components/page.php';
require_once './repository/tour-operator.php';
require_once './components/crud_mode.php';
require_once './model/message.php';

class TouroperatorDetailPage implements Page {
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
            $entity = new Touroperator(NULL, NULL);
        }
        $mode = $id ? CrudMode::edit() : CrudMode::create();
        $this->state = new TouroperatorDetailState($entity, $mode);
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
        $name = strip_tags($_POST['name']);
        $entity = new Touroperator($id, $name);

        try {
            $this->context->touroperatorValidator()->validate($entity);
            $this->context->touroperatorRepository()->update($entity);
            $this->context->messageService()->add(Message::success(Texts::tourposition_updated));
            $this->state = new TouroperatorDetailState($entity, CrudMode::edit());
        } catch(\Exception $ex) {
            $messages = $this->context->exceptionMapper()->getMessages($ex);
            $this->context->messageService()->addAll($messages);
            $this->state = new TouroperatorDetailState($entity, CrudMode::edit());
        }
    }

    private function processCreate() {
        $name = strip_tags($_POST['name']);
        $entity = new Touroperator(NULL, $name);

        try {
            $this->context->touroperatorValidator()->validate($entity);
            $id = $this->context->touroperatorRepository()->create($entity);
            $this->context->router()->redirect('/admin/tour-operator/'.$id);
        } catch(\Exception $ex) {
            $messages = $this->context->exceptionMapper()->getMessages($ex);
            $this->context->messageService()->addAll($messages);
            $this->state = new TouroperatorDetailState($entity, CrudMode::create());
        }
    }
    
	public function template() : string {
		return 'tour-operators/tour-operator.html';
	}
	
	public function context() : array {
		return [
            'state' => $this->state
		];
    }
    
    private function findById($id) {
        $entity = $this->context->touroperatorRepository()->findById($id);
        if($entity) {
            return $entity;
        }
        $this->context->router()->notFound();
    }

    private function getId() {
        $id = end(explode('/', getenv('REQUEST_URI')));
        return $id === 'tour-operator' ? NULL : $id;
    }
}

class TouroperatorDetailState {
    public $entity;
    public $mode;

    function __construct($entity, $mode) {
        $this->entity = $entity;
        $this->mode = $mode;
    }
}
?>