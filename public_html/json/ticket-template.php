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
			'ticketTemplateId' => $textDefinition->ticketTemplateId(),
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

	private function mapList(array $list, $mappingFunction) {
		$mapped = [];
		foreach($list as &$item) {
			$mapped[] = $mappingFunction($item);
		}
		return $mapped;
	}
}

?>