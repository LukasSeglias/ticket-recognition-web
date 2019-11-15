<?php
namespace CTI;

class TicketTemplateRef {

    private $id;
    private $key;

    function __construct($id, $key) {
        $this->id = $id;
        $this->key = $key;
    }

    public function id() {
        return $this->id;
    }

    public function key() {
        return $this->key;
    }
}
?>