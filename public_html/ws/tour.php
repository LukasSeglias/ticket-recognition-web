<?php

namespace CTI;

class TourResource {

    private $context;
    private $positionSubresource;

    function __construct($context) {
        $this->context = $context;
        $this->positionSubresource = new TourpositionSubresource($context);
    }

    public function process() {
        $tourId = $this->getTourId();
        $tourpositionId = $this->getTourpositionId();

        if(!is_null($tourId) && !is_null($tourpositionId)) {

            return $this->positionSubresource->process($tourId, $tourpositionId);

        } elseif(!is_null($tourId)) {

            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                return $this->delete($tourId);
            }

        }
        $this->context->router()->notFound();
    }

    private function delete($id) {
        try {
            $this->findById($id);
            $this->context->tourRepository()->delete($id);
        } catch(\Exception $ex) {
            $messages = $this->context->exceptionMapper()->getMessages($ex);
            http_response_code(400);
            return $this->context->messageJsonMapper()->toJson($messages);
        }
    }

    private function findById($id) {
        $entity = $this->context->tourRepository()->findById($id);
        if($entity === NULL) {
            $this->context->router()->notFound();
        }
        return $entity;
    }

    private function getTourpositionId() {
        $explodedPath = explode('/', getenv('REQUEST_URI'));
        if($explodedPath[count($explodedPath) - 2] === 'tours') {
            
            return NULL;

        } elseif($explodedPath[count($explodedPath) - 2] === 'positions') {

            return end($explodedPath);

        } else {
            return NULL;
        }
    }

    private function getTourId() {
        $explodedPath = explode('/', getenv('REQUEST_URI'));
        if($explodedPath[count($explodedPath) - 2] === 'tours') {
            
            return end($explodedPath);

        } elseif($explodedPath[count($explodedPath) - 2] === 'positions') {

            $id = $explodedPath[count($explodedPath) - 3];
            return $id === 'tours' ? NULL : $id;

        } else {
            return NULL;
        }
    }
}

class TourpositionSubresource {

    private $context;

    function __construct($context) {
        $this->context = $context;
    }

    public function process($tourId, $positionId) {

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

}

?>