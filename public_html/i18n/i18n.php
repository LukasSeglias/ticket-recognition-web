<?php
namespace CTI;
use \i18n;

require_once './vendor/autoload.php';

$i18n = new i18n();
$i18n->setCachePath(getenv('CTI_TEMP_DIRECTORY') . '/cache/i18n');
$i18n->setFilePath('./i18n/lang_{LANGUAGE}.ini');

if (isset($_COOKIE['USER_LANGUAGE'])) {
    $i18n->setForcedLang($_COOKIE['USER_LANGUAGE']);
}

$i18n->init();

// 'Change' namespace of L-class to our own
class_alias('L', '\CTI\Texts');

function Texts($key, $args) {
    return L($key, $args);
}

?>