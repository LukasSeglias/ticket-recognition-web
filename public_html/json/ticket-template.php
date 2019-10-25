<?php
namespace CTI;

require_once './model/text-definition.php';
require_once './model/tour-operator.php';
require_once './model/ticket-template.php';

class TicketTemplateJsonMapper {

	function __construct() {
		
	}

	public function toJson($templates) : string {
		return json_encode($this->mapList($templates, function($item) {
			return $this->mapTemplate($item);
		}));
	}

	private function mapTemplate(TicketTemplate $template) {
		return [
			'id' => $template->id(),
			'key' => $template->key(),
			'touroperator' => $this->mapTourOperator($template->touroperator()),
			'textDefinitions' => $this->mapList($template->textDefinitions(), function($item) {
				return $this->mapTextDefinition($item);
			})
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