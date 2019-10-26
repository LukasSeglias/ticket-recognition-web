<?php
namespace CTI;

require_once './context.php';
require_once './components/page.php';
require_once './templates.php';

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
		$templatingEngine = new TemplatingEngine();
		return $templatingEngine->render($this->page->template(), $this->context());
	}

	function context() : array {
		return array_merge($this->baseContext, $this->page->context());
	}
}
?>