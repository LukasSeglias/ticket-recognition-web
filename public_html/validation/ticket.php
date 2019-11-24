<?php
namespace CTI;

require_once './i18n/i18n.php';
require_once './validation/validation-context.php';
require_once './validation/validation-exception.php';

class TicketValidator {

    function __construct() {

    }

    public function validate($entity) {
        $context = new ValidationContext();

        $valid = $context->nonNull($entity, Texts::invalid_value);
        $valid = $valid && $context->nonEmpty($entity->template(), Texts::invalid_value);
        $valid = $context->nonNull($entity->tour(), Texts::invalid_value);
        $valid = $valid && $context->nonNull($entity->scanDate(), Texts::invalid_value);
        $valid = $valid && $context->isDate($entity->scanDate(), Texts::invalid_value);
        
        // TODO: handle duplicate key for create and update
        // TODO: validate text-definitions

        if($context->hasErrors()) {
            throw new ValidationException($context->errors());
        }
    }

}

?>