<?php
namespace CTI;
use \Twig\Environment;
use \Twig\TwigFilter;
use \Twig\Loader\FilesystemLoader;

require_once './vendor/autoload.php';
require_once './i18n/i18n.php';

class TemplatingEngine {
	
	private $twig;
	
	function __construct() {
		$loader = new FilesystemLoader('./components');
		$this->twig = new Environment($loader, [
			'cache' => './tmp/cache/twig',
		]);
		$this->twig->addFilter(new TwigFilter('translated', function ($key, $args = []) {
			return L($key, $args);
		}));
	}
	
	public function render($template, $context) {
		return $this->twig->render($template, $context);
	}
}
?>