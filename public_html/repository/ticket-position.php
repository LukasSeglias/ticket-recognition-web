<?php

namespace CTI;

require_once './model/ticket-position.php';

class TicketPositionRepository {
    private $databaseService;

    function __construct($databaseService) {
        $this->databaseService = $databaseService;
    }

    public function findByTicketId($ticketId) {
        return $this->findBy(NULL, $ticketId);
    }

    public function findById($id) {
        return $this->findBy($id, NULL);
    }

    public function findBy($id, $ticketId) {
        $builder = new TicketPosition\QueryBuilder;
        $query = $builder->setId($id)
            ->setTicketId($ticketId)
            ->build();
        $statement = $this->databaseService->pdo()->prepare($query);
        $statement->execute($builder->mapping());
        $results = array();
        while($row = $statement->fetch()) {
            $results[] = $this->map($row);
        }
        return $results;
    }

    public function delete($id) {
        $statement = $this->databaseService->pdo()->prepare('DELETE FROM ticket_position WHERE id = :id');
        $statement->execute([':id' => $id]);
    }

    public function create($ticketId, $position) {
        $pdo = $this->databaseService->pdo();

        $statement = $pdo->prepare("INSERT INTO ticket_position(description, code, ticket_id) VALUES(:description, :code, :ticket_id) RETURNING id");
        $statement->execute(array(
                ':description' => $position->description(),
                ':code' => $position->code(),
                ':ticket_id' => $ticketId)
        );
    }

    private function map($row) : TicketPosition {
        return new TicketPosition(
            $row['id'],
            $row['description'],
            $row['code'],
            $row['ticket_id']
        );
    }
}

namespace CTI\TicketPosition;

class QueryBuilder {
    private $mapping = array();

    public function setTicketId($ticket_id) : QueryBuilder {
        if (!$this->isNullOrEmpty($ticket_id)) {
            $this->mapping[':ticket_id'] = $ticket_id;
        }
        return $this;
    }

    public function setId($id) : QueryBuilder {
        if (!$this->isNullOrEmpty($id)) {
            $this->mapping[':id'] = $id;
        }
        return $this;
    }

    public function mapping() {
        return $this->mapping;
    }

    public function build() {
        $query = 'SELECT id, description, code, ticket_id FROM ticket_position';
        $and = 'WHERE';

        if (array_key_exists(':ticket_id', $this->mapping)) {
            $query .= ' ' . $and . ' ticket_id = :ticket_id';
            $and = 'AND';
        }

        if (array_key_exists(':id', $this->mapping)) {
            $query .= ' ' . $and . ' id = :id';
        }

        return $query;
    }

    function isNullOrEmpty($str){
        return (!isset($str) || trim($str) === '');
    }
}

?>