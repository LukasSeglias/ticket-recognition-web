<?php
namespace CTI;

require_once './model/message.php';

class ValidationContext {
	
	private $errors;
	
	public function __construct() {
		$this->errors = [];
	}

	public function assert($condition, $message) : bool {
		if(!$condition) {
			$this->addError($message);
			return false;
		}
		return true;
	}

	public function nonNull($value, $message) : bool {
		return $this->assert(!is_null($value), $message);
	}

	public function nonEmpty($value, $message) : bool {
		return $this->assert(!empty($value), $message);
	}

	public function integer($value, $message) : bool {
		return $this->assert(ctype_digit($value), $message);
	}

	public function string($value, $message) : bool {
		return $this->assert(is_string($value), $message);
	}

	public function maxLength($value, $maxLength, $message) : bool {
		return $this->assert(mb_strlen($value) <= $maxLength, $message);
	}

	public function isDate($value, $message) : bool {
	    $format = 'Y-m-d\TH:i:s';
        $d = \DateTime::createFromFormat($format, $value);
        $isValid = $d && $d->format($format) == $value;
	    return $this->assert($isValid, $message);
    }

	public function errors() : array {
		return $this->errors;
	}

	public function hasErrors() : bool {
		return !empty($this->errors);
	}

	private function addError($message) {
		$this->errors[] = Message::error($message);
	}

}
?>