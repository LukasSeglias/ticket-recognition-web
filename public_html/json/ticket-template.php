<?php
namespace CTI;

require_once './model/text-definition.php';
require_once './model/tour-operator.php';
require_once './model/ticket-template.php';

class TicketTemplateJsonMapper {

	function __construct() {
		
	}

	public function toJson($arg) : string {
		if(is_array($arg)){
			return json_encode($this->mapList($arg, function($item) {
				return $this->mapTemplate($item);
			}));
		} else {
			return json_encode($this->mapTemplate($arg));
		}
	}

	public function fromJsonArray($jsonString) {
		$array = json_decode($jsonString);
		return $this->mapList($array, function($item) {
			return $this->ticketTemplateFromJson($item);
		});
	}

	public function fromJsonObject($jsonString) {
		$obj = json_decode($jsonString);
		return $this->ticketTemplateFromJson($obj);
	}

	private function mapTemplate(TicketTemplate $template) {
		return [
			'id' => $template->id(),
			'key' => $template->key(),
			'touroperator' => $this->mapTourOperator($template->touroperator()),
			'textDefinitions' => $this->mapList($template->textDefinitions(), function($item) {
				return $this->mapTextDefinition($item);
			}),
			'imageFilename' => $template->imageFilename()
		];
	}

	private function mapTextDefinition(TextDefinition $textDefinition) {
		return [
			'id' => $textDefinition->id(),
			'key' => $textDefinition->key(),
			'description' => $textDefinition->description(),
			'rectangle' => [
				'x' => $textDefinition->rectangle()->x(),
				'y' => $textDefinition->rectangle()->y(),
				'width' => $textDefinition->rectangle()->width(),
				'height' => $textDefinition->rectangle()->height()
			]
		];
	}

	private function mapTourOperator(TourOperator $tourOperator) {
		return [
			'id' => $tourOperator->id(),
			'name' => $tourOperator->name()
		];
	}
	
	private function ticketTemplateFromJson($jsonObj) {
		return new TicketTemplate(
			$jsonObj->id, $jsonObj->key, $this->tourOperatorFromJson($jsonObj->touroperator), 
			$this->mapList($jsonObj->textDefinitions, function($item) use(&$jsonObj) {
				return $this->textDefinitionFromJson($jsonObj->id, $item);
			}),
			$jsonObj->imageFilename
		);
	}

	private function textDefinitionFromJson($ticketTemplateId, $jsonObj) {
		$rectangle = $jsonObj->rectangle;
		return new TextDefinition(
			$jsonObj->id, $jsonObj->key, $ticketTemplateId, $jsonObj->description,
			new Rectangle($rectangle->x, $rectangle->y, $rectangle->width, $rectangle->height)
		);
	}

	private function tourOperatorFromJson($jsonObj) {
		return new TourOperator($jsonObj->id, $jsonObj->name);
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