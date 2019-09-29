<?php
namespace CTI;
use \i18n;

require_once './vendor/autoload.php';

$i18n = new i18n();
$i18n->setCachePath('./tmp/cache/i18n');
$i18n->setFilePath('./i18n/lang_{LANGUAGE}.ini');
$i18n->init();

// 'Change' namespace of L-class to our own
class_alias('L', '\CTI\L');

?>