<?php

namespace CTI;

class TourPositionResource {

    private $context;

    function __construct($context) {
        $this->context = $context;
    }

    public function process() {
        $positionId = $this->getId();
        $tourId = $this->getTourId();

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            return $this->delete($tourId, $positionId);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->create($tourId, $positionId);
        }
    }

    private function create($tourId, $positionId) {
        if ($positionId == NULL || $tourId == NULL) {
            $this->context->router()->notFound();
        }
        $this->context->tourRepository()->addPosition($tourId, $positionId);
    }

    private function delete($tourId, $positionId) {
        try {
            $this->context->tourRepository()->removePosition($tourId, $positionId);
        } catch(\Exception $ex) {
            $messages = $this->context->exceptionMapper()->getMessages($ex);
            http_response_code(400);
            return $this->context->messageJsonMapper()->toJson($messages);
        }
    }

    private function getId() {
        $id = end(explode('/', getenv('REQUEST_URI')));
        return $id === 'positions' ? NULL : $id;
    }

    private function getTourId() {
        $explodedPath = explode('/', getenv('REQUEST_URI'));
        $id = $explodedPath[count($explodedPath) - 2];
        return $id === 'positions' ? NULL : $id;
    }
}

?>