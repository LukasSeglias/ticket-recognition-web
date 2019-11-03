<?php
namespace CTI;

class Message {
	
	const TYPE_ERROR = "danger";
	const TYPE_SUCCESS = "success";
	const TYPE_WARNING = "warning";
	const TYPE_INFO = "info";

	private $type;
	private $message;
	
	public function __construct($type, $message) {
		$this->type = $type;
		$this->message = $message;
	}

	public static function error($message) : Message {
		return new Message(self::TYPE_ERROR, $message);
	}

	public static function success($message) : Message {
		return new Message(self::TYPE_SUCCESS, $message);
	}

	public static function warning($message) : Message {
		return new Message(self::TYPE_WARNING, $message);
	}

	public static function info($message) : Message {
		return new Message(self::TYPE_INFO, $message);
	}

	public function type() : string {
		return $this->type;
	}

	public function message() : string {
		return $this->message;
	}
}

?>