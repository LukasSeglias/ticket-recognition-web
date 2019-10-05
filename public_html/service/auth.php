<?php
namespace CTI;

require_once './model/user.php';

class AuthService {
	
	function __construct() {
		
	}
	
	public function currentUser() : User {
		// TODO: insert real implementation
		return new User('seglias', 'Lukas', 'Seglias');
	}

}

?>