<?php
namespace CTI;

require_once './i18n/i18n.php';
require_once './validation/validation-context.php';
require_once './validation/validation-exception.php';

class TouroperatorValidator {

	function __construct() {
		
	}

	public function validate($entity) {
		$context = new ValidationContext();

		$valid = $context->nonNull($entity, Texts::invalid_value);
		$descValid = $valid && $context->nonEmpty($entity->name(), Texts::touroperator_name_invalid);
		$descValid = $descValid && $context->maxLength($entity->name(), 100, Texts::touroperator_name_invalid);

		if($context->hasErrors()) {
			throw new ValidationException($context->errors());
		}
	}

}

?>