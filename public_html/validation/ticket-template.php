<?php
namespace CTI;

require_once './i18n/i18n.php';
require_once './model/text-definition.php';
require_once './model/tour-operator.php';
require_once './model/ticket-template.php';
require_once './validation/validation-error.php';

class TicketTemplateValidator {

	function __construct() {
		
	}

	public function validate($entity) {
		$errors = array();

		if(is_null($entity)) {
			$errors[] = new ValidationError(Texts::invalid_value);
			return $errors;
		}
		if(is_null($entity->id())) {
			$errors[] = new ValidationError(Texts::invalid_value);
		}
		if(empty($entity->key())) {
			$errors[] = new ValidationError(Texts::invalid_value);
		}
		if(empty($entity->imageFilename())) {
			$errors[] = new ValidationError(Texts::invalid_value);
		}
		if(is_null($entity->touroperator())) {
			$errors[] = new ValidationError(Texts::invalid_value);
		}
		if(is_null($entity->textDefinitions())) {
			$errors[] = new ValidationError(Texts::invalid_value);
		}

		// TODO: handle create case where ID is null
		// TODO: handle duplicate key for create
		// TODO: handle duplicate key for update
		// TODO: validate text-definitions
	}

}

?>