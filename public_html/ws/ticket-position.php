<?php

namespace CTI;

class TicketPositionResource {

    private $context;

    function __construct($context) {
        $this->context = $context;
    }

    public function process() {
        $id = $this->getId();

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            return $this->delete($id);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ticketId = $this->getTicketId();
            $this->create($id, $ticketId);
        }
    }

    private function create($positionId, $ticketId) {
        if ($positionId == NULL || $ticketId == NULL) {
            $this->context->router()->notFound();
        }
        $position = $this->context->tourPositionRepository()->get($positionId);
        $this->context->ticketPositionRepository()->create($ticketId, $position);
    }

    private function delete($id) {
        try {
            $this->findById($id);
            $this->context->ticketPositionRepository()->delete($id);
        } catch(\Exception $ex) {
            $messages = $this->context->exceptionMapper()->getMessages($ex);
            http_response_code(400);
            return $this->context->messageJsonMapper()->toJson($messages);
        }
    }

    private function findById($id) {
        $entity = $this->context->ticketPositionRepository()->findById($id);
        if($entity === NULL) {
            $this->context->router()->notFound();
        }
        return $entity;
    }

    private function getId() {
        $id = end(explode('/', getenv('REQUEST_URI')));
        return $id === 'ticket-positions' ? NULL : $id;
    }

    private function getTicketId() {
        $explodedPath = explode('/', getenv('REQUEST_URI'));
        $id = $explodedPath[count($explodedPath) - 2];
        return $id === 'ticket-position' ? NULL : $id;
    }
}

?>