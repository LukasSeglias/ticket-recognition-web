<?php
namespace CTI;

class Router {

	private $redirectedLocation;

	function redirect(string $location) {
		$this->redirectedLocation = $location;
	}

	function redirectRequested() {
		return $this->redirectedLocation !== NULL;
	}

	function render() : string {
		header('Location: ' . $this->redirectedLocation);
	}
}
?>