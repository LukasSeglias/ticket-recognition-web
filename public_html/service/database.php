<?php
namespace CTI;

class DatabaseService {

	private $pdo;

	function __construct($connection, $user, $password) {
		try {
			$this->pdo = new \PDO($connection, $user, $password);
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
	}

	function pdo() {
		return $this->pdo;
	}
}
?>