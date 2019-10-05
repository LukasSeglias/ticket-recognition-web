<?php
namespace CTI;

class CrudMode {
	
	const MODE_VIEW = 1;
	const MODE_CREATE = 2;
	const MODE_EDIT = 3;
	
	public static function view() : CrudMode {
		return new CrudMode(self::MODE_VIEW);
	}
	
	public static function create() : CrudMode {
		return new CrudMode(self::MODE_CREATE);
	}
	
	public static function edit() : CrudMode {
		return new CrudMode(self::MODE_EDIT);
	}
	
	private $mode;
	
	private function __construct($mode) {
		$this->mode = $mode;
	}
	
	public function isView() {
		return $this->mode == self::MODE_VIEW;
	}
	
	public function isCreate() {
		return $this->mode == self::MODE_CREATE;
	}
	
	public function isEdit() {
		return $this->mode == self::MODE_EDIT;
	}
}
?>