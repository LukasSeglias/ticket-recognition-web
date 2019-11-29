<?php

namespace CTI;

class TicketResource {

    private $context;

    function __construct($context) {
        $this->context = $context;
    }

    public function process() {
        $id = $this->getId();

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            return $this->delete($id);
        }
    }

    private function delete($id) {
        try {
            $this->findById($id);
            $this->context->ticketRepository()->delete($id);
        } catch(\Exception $ex) {
            $messages = $this->context->exceptionMapper()->getMessages($ex);
            http_response_code(400);
            return $this->context->messageJsonMapper()->toJson($messages);
        }
    }

    private function findById($id) {
        $entity = $this->context->ticketRepository()->get($id);
        if($entity === NULL) {
            $this->context->router()->notFound();
        }
        return $entity;
    }

    private function getId() {
        $id = end(explode('/', getenv('REQUEST_URI')));
        return $id === 'tickets' ? NULL : $id;
    }
}

?>