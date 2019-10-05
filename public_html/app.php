<?php
namespace CTI;

require_once './context.php';
require_once './components/page.php';
require_once './templates/templates.php';

class App {

	private $context;
	private $page;
	private $baseContext;

	function __construct(Context $context, Page $page, array $baseContext) {
		$this->context = $context;
		$this->page = $page;
		$this->baseContext = $baseContext;
	}

	function update() {
		$this->page->update();
	}

	function render() : string {
		$router = $this->context->router();
		if($router->redirectRequested()) {
			return $router->render();
		} else {
			$templatingEngine = new TemplatingEngine();
			return $templatingEngine->render($this->page->template(), $this->context());
		}
	}

	function context() : array {
		return array_merge($this->baseContext, $this->page->context());
	}
}
?>