<?php
namespace CTI;

class DatabaseService {

	private $pdo;

	public function __construct($connection, $user, $password) {
		try {
			$this->pdo = new \PDO($connection, $user, $password);
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
	}

	public function pdo() {
		return $this->pdo;
	}
}
?>