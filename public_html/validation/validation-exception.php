<?php
namespace CTI;

require_once './model/message.php';

class ValidationException extends \Exception {

	private $messages;

    public function __construct(array $messages) {
        $this->messages = $messages;
        parent::__construct("Validation error", 0, NULL);
    }

	public function messages() : array {
		return $this->messages;
	}
}
?>