<?php
namespace CTI;

require_once './i18n/i18n.php';
require_once './validation/validation-context.php';
require_once './validation/validation-exception.php';

class TourpositionValidator {

	function __construct() {
		
	}

	public function validate($entity) {
		$context = new ValidationContext();

		$valid = $context->nonNull($entity, Texts::invalid_value);
		$codeValid = $valid && $context->nonEmpty($entity->code(), Texts::tourposition_code_invalid);
		$codeValid = $codeValid && $context->integer($entity->code(), Texts::tourposition_code_invalid);
		$descValid = $valid && $context->nonEmpty($entity->description(), Texts::tourposition_description_invalid);
		$descValid = $descValid && $context->maxLength($entity->description(), 100, Texts::tourposition_description_invalid);

		if($context->hasErrors()) {
			throw new ValidationException($context->errors());
		}
	}

}

?>