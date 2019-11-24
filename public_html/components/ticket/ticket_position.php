<?php

namespace CTI;

class TicketPositionPage implements Page {

    private $context;
    private $state;

    function __construct($context) {
        $this->context = $context;
    }

    public function update() {
        $id = $this->getId();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($id == NULL) {
                $this->context->router()->redirect("/admin/tickets");
            }

            $filter = new TicketPositionPageFilter($_POST['positioncode']);
            $results = $this->loadResults($filter, $id);
            $this->state = new TicketPositionPageState($results, $filter, $id);
        } else {
            $filter = new TicketPositionPageFilter($_POST['positioncode']);
            $results = $this->loadResults($filter, $id);
            $this->state = new TicketPositionPageState($results, new TicketPositionPageFilter(NULL), $id);
        }
    }

    public function template() : string {
        return 'ticket/ticket_position.html';
    }

    public function context() : array {
        return [
            'state' => $this->state
        ];
    }

    private function loadResults(TicketPositionPageFilter $filter, $id) : array {
        $allTourPositions = $this->context->tourPositionRepository()->findBy(NULL, $filter->code);
        $appliedTourPositions = $this->context->ticketPositionRepository()->findByTicketId($id);
        $results = array();

        foreach ($allTourPositions as $tourPosition) {
            $applied = NULL;
            foreach ($appliedTourPositions as $appliedPosition) {
                if ($tourPosition->code() === $appliedPosition->code()) {
                    $applied = $appliedPosition;
                    break;
                }
            }

            if ($applied !== NULL) {
                $value = $applied;
            } else {
                $value = new TicketPosition($tourPosition->id(), $tourPosition->description(), $tourPosition->code(), NULL);
            }

            array_push($results, $value);
        }

        return $results;
    }

    private function getId() {
        $id = end(explode('/', getenv('REQUEST_URI')));
        return $id === 'ticket-position' ? NULL : $id;
    }
}

class TicketPositionPageState {
    public $items;
    public $filter;
    public $ticketId;

    function __construct(array $items, TicketPositionPageFilter $filter, $ticketId) {
        $this->items = $items;
        $this->filter = $filter;
        $this->ticketId = $ticketId;
    }
}

class TicketPositionPageFilter {
    public $code;

    function __construct($code) {
        $this->code = $code;
    }
}

?>