<?php

namespace CTI;

require_once './model/ticket.php';

class TicketRepository {

    private $databaseService;
    private $ticketPositionRepository;

    function __construct($databaseService, $ticketPositionRepository) {
        $this->databaseService = $databaseService;
        $this->ticketPositionRepository = $ticketPositionRepository;
    }

    public function find($limit) {
        $builder = new Ticket\QueryBuilder;
        $query = $builder->limit($limit)->build();
        $statement = $this->databaseService->pdo()->prepare($query);
        $statement->execute($builder->mapping());
        $results = array();
        while($row = $statement->fetch()) {
            $results[] = $this->map($row);
        }
        return $results;
    }

    public function findBy($code) {
        $builder = new Ticket\QueryBuilder;
        $query = $builder->setCode($code)
            ->build();
        $statement = $this->databaseService->pdo()->prepare($query);
        $statement->execute($builder->mapping());
        $results = array();
        while($row = $statement->fetch()) {
            $results[] = $this->map($row);
        }
        return $results;
    }

    public function get($id) {
        $builder = new Ticket\QueryBuilder;
        $query = $builder->setId($id)
            ->build();
        $statement = $this->databaseService->pdo()->prepare($query);
        $statement->execute([':tiId' => $id]);
        $entity = null;
        if($row = $statement->fetch()) {
            $entity = $this->map($row);
        }
        return $entity;
    }

    public function create($ticketTemplateId, $tourId) {
        $statement = $this->databaseService->pdo()->prepare('INSERT INTO ticket (ticket_template_id, tour_id, scan_date) VALUES (:ticket_template_id,:tour_id, NOW()) RETURNING id');
        $statement->execute([
            ':ticket_template_id' => $ticketTemplateId,
            ':tour_id' => $tourId]);
        if ($row = $statement->fetch()) {
            return $row['id'];
        }
        return -1;
    }

    public function update($entity) {
        $statement = $this->databaseService->pdo()->prepare('UPDATE ticket SET ticket_template_id = :ticket_template_id, tour_id = :tour_id, scan_date = :scan_date WHERE id = :id');
        $statement->execute([
            ':id' => $entity->id(),
            ':ticket_template_id' => $entity->template()->id(),
            ':tour_id' => $entity->tour()->id(),
            ':scan_date' => $entity->scanDate()]);
    }

    public function delete($id) {
        $statement = $this->databaseService->pdo()->prepare('DELETE FROM ticket_position WHERE ticket_id = :id');
        $statement->execute([':id' => $id]);
        $statement = $this->databaseService->pdo()->prepare('DELETE FROM ticket WHERE id = :id');
        $statement->execute([':id' => $id]);
    }

    public function addPosition($ticketId, $description, $code) {
        $statement = $this->databaseService->pdo()->prepare('INSERT INTO ticket_position (ticket_id, description, code) VALUES (:ticketId,:description,:code)');
		$statement->execute([':ticketId' => $ticketId, ':description' => $description, ':code' => $code]);
    }

    private function map($row) : Ticket {
        return new Ticket(
            $row['ticket_id'],
            new TicketTemplateRef($row['ticket_template_id'], $row['ticket_template_key']),
            new TourRef($row['tour_id'], $row['tour_description'], $row['tour_code']),
            $row['ticket_scan_date'],
            $this->ticketPositionRepository->findByTicketId($row['ticket_id'])
        );
    }
}

namespace CTI\Ticket;

class QueryBuilder {
    private $mapping = array();
    private $limit = NULL;

    public function setCode($code) : QueryBuilder {
        if (!$this->isNullOrEmpty($code)) {
            $this->mapping[':touCode'] = $code;
        }
        return $this;
    }

    public function setId($id) : QueryBuilder {
        if (!$this->isNullOrEmpty($id)) {
            $this->mapping[':tiId'] = $id;
        }
        return $this;
    }

    public function limit(int $limit) : QueryBuilder {
        if ($limit >= 0) {
            $this->limit = $limit;
        }
        return $this;
    }

    public function mapping() {
        return $this->mapping;
    }

    public function build() {
        $query = 'SELECT ti.id AS ticket_id,
                         ti.scan_date AS ticket_scan_date,
                         tt.id AS ticket_template_id,
                         tt.key AS ticket_template_key,
                         tou.id AS tour_id,
                         tou.description AS tour_description,
                         tou.code AS tour_code
                         FROM ticket as ti
                         inner join ticket_template as tt on ti.ticket_template_id = tt.id
                         inner join tour tou on ti.tour_id = tou.id';
        $and = 'WHERE';

        if (array_key_exists(':touCode', $this->mapping)) {
            $query .= ' ' . $and . ' tou.code = :touCode';
            $and = 'AND';
        }

        if (array_key_exists(':tiId', $this->mapping)) {
            $query .= ' ' . $and . ' ti.id = :tiId';
        }

        $query .= ' ORDER BY scan_date desc';

        if(!is_null($this->limit)) {
            $query .= ' LIMIT ' . strval($this->limit);
        }

        return $query;
    }

    function isNullOrEmpty($str){
        return (!isset($str) || trim($str) === '');
    }
}

?>