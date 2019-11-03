<?php
namespace CTI;

require_once './i18n/i18n.php';
require_once './model/message.php';
require_once './validation/validation-exception.php';

class ExceptionMapper {

	// POSTGRESQL-Errorcodes
	const CODE_UNIQUE_CONSTRAINT = "23505";
	const CODE_FOREIN_KEY_CONSTRAINT = "23503";

	function __construct() {
	}

	public function getMessages(\Exception $ex) : array {
		
		if($ex instanceof \PDOException) {

			if($ex->getCode() === self::CODE_UNIQUE_CONSTRAINT) {

				return array(Message::error(Texts::errors_db_unique_constraint));

			} elseif($ex->getCode() === self::CODE_FOREIN_KEY_CONSTRAINT) {

				return array(Message::error(Texts::errors_db_foreignkey_constraint));
			} else {
				return array(Message::error(Texts::errors_db_general));
			}
			
		} elseif($ex instanceof ValidationException) {

			return $ex->messages();

		} elseif($ex instanceof \Exception) {
			return array(Message::error(Texts::errors_general));
		} else {
			return [];
		}
	}

}

?>