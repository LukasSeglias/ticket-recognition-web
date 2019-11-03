<?php
namespace CTI;

require_once './model/message.php';

class MessageJsonMapper {

	function __construct() {
		
	}

	public function toJson($arg) : string {
		if(is_array($arg)){
			return json_encode($this->mapList($arg, function($item) {
				return $this->mapMessage($item);
			}));
		} else {
			return json_encode($this->mapMessage($arg));
		}
	}

	private function mapMessage(Message $msg) {
		return [
			'type' => $msg->type(),
			'message' => $msg->message()
		];
	}

	private function mapList(array $list, $mappingFunction) {
		$mapped = [];
		foreach($list as &$item) {
			$mapped[] = $mappingFunction($item);
		}
		return $mapped;
	}
}

?>