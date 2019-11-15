<?php
namespace CTI;

class TicketPosition {

    private $id;
    private $description;
    private $code;
    private $ticket_id;

    function __construct($id, $description, $code, $ticket_id) {
        $this->id = $id;
        $this->description = $description;
        $this->code = $code;
        $this->ticket_id = $ticket_id;
    }

    public function id() {
        return $this->id;
    }

    public function description() {
        return $this->description;
    }

    public function code() {
        return $this->code;
    }

    public function ticketId() {
        return $this->ticket_id;
    }
}
?>