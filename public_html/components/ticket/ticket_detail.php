<?php
namespace CTI;

require_once './components/page.php';
require_once './components/crud_mode.php';
require_once './model/ticket.php';

class TicketDetailPage implements Page {
	
	private $context;
	private $state;
	private $templates;
	private $tours;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
	    $this->templates = $this->context->ticketTemplateRepository()->findAll();
	    $this->tours = $this->context->tourRepository()->findAll();

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
            $entity = new Ticket(NULL, new TicketTemplateRef(NULL, NULL), new TourRef(NULL, NULL, NULL), NULL, []);
        }
        $mode = $id ? CrudMode::edit() : CrudMode::create();
        $this->state = new TicketDetailState($entity, $mode);
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
        $existing =  $this->findById($id);// Check existence
        $entity = new Ticket($id,
            new TicketTemplateRef($_POST['template'], $existing->template()->key()),
            new TourRef($_POST['tour'], $existing->tour()->description(), $existing->tour()->code()),
            $_POST['scanDate'],
            $existing->positions());

        try {
            $this->context->ticketValidator()->validate($entity);
            $this->context->ticketRepository()->update($entity);
            $this->context->messageService()->add(Message::success(Texts::ticket_updated));
            $this->state = new TicketDetailState($entity, CrudMode::edit());
        } catch(\Exception $ex) {
            $messages = $this->context->exceptionMapper()->getMessages($ex);
            $this->context->messageService()->addAll($messages);
            $this->state = new TicketDetailState($entity, CrudMode::edit());
        }
    }

    private function processCreate() {
        $description = strip_tags($_POST['description']);
        $code = strip_tags($_POST['code']);
        $entity = new TourPosition(NULL, $description, $code);

        try {
            $this->context->ticketValidator()->validate($entity);
            $id = $this->context->ticketRepository()->create($entity);
            $this->context->router()->redirect('/admin/tour-position/'.$id);
        } catch(\Exception $ex) {
            $messages = $this->context->exceptionMapper()->getMessages($ex);
            $this->context->messageService()->addAll($messages);
            $this->state = new TicketDetailState($entity, CrudMode::create());
        }
    }

    private function findById($id) {
        $entity = $this->context->ticketRepository()->get($id);
        if($entity) {
            return $entity;
        }
        $this->context->router()->notFound();
    }

    private function getId() {
        $id = end(explode('/', getenv('REQUEST_URI')));
        return $id === 'ticket' ? NULL : $id;
    }
	
	public function template() : string {
		return 'ticket/ticket_detail.html';
	}
	
	public function context() : array {
		return [
			"state" => $this->state,
            "tours" => $this->tours,
            "templates" => $this->templates
		];
	}
}


class TicketDetailState {
	
	private $ticket;
	private $mode;
	
	function __construct(Ticket $ticket, CrudMode $mode) {
		$this->ticket = $ticket;
		$this->mode = $mode;
	}
	
	public function ticket() : Ticket {
		return $this->ticket;
	}
	
	public function mode() : CrudMode {
		return $this->mode;
	}
	
}
?>