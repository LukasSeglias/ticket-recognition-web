<?php
namespace CTI;

require_once './i18n/i18n.php';
require_once './validation/validation-context.php';
require_once './validation/validation-exception.php';

class TourValidator {

	function __construct() {
		
	}

	public function validate($entity) {
		$context = new ValidationContext();

		$valid = $context->nonNull($entity, Texts::invalid_value);
		$codeValid = $valid && $context->nonEmpty($entity->code(), Texts::tour_code_invalid);
		$codeValid = $codeValid && $context->integer($entity->code(), Texts::tour_code_invalid);
		$descValid = $valid && $context->nonEmpty($entity->description(), Texts::tour_description_invalid);
		$descValid = $descValid && $context->maxLength($entity->description(), 100, Texts::tour_description_invalid);

		// TODO: handle duplicate code on create and edit

		if($context->hasErrors()) {
			throw new ValidationException($context->errors());
		}
	}

}

?>