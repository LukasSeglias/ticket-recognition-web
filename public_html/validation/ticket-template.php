<?php
namespace CTI;

require_once './i18n/i18n.php';
require_once './validation/validation-context.php';
require_once './validation/validation-exception.php';

class TicketTemplateValidator {

	function __construct() {
		
	}

	public function validate($entity) {
		$context = new ValidationContext();

		$valid = $context->nonNull($entity, Texts::invalid_value);
		$valid = $valid && $context->nonEmpty($entity->imageFilename(), Texts::invalid_value);
		$valid = $context->nonNull($entity->touroperator(), Texts::invalid_value);
		$valid = $context->nonNull($entity->textDefinitions(), Texts::invalid_value);
		$keyValid = $valid && $context->nonEmpty($entity->key(), Texts::tickettemplate_key_invalid);
		$keyValid = $keyValid && $context->maxLength($entity->key(), 50, Texts::tickettemplate_key_invalid);

		if($context->hasErrors()) {
			throw new ValidationException($context->errors());
		}
	}

}

?>