<?php
namespace CTI;

class DatabaseService {

	private $pdo;

	function __construct($config) {
		try {
			$this->pdo = new \PDO($config['dsn'], $config['username'], $config['password']);
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