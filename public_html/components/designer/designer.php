<?php
namespace CTI;

require_once './components/page.php';

class DesignerPage implements Page {
	
	private $context;
	private $state;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
		
		$touroperators = $this->context->touroperatorRepository()->findAll();
		$selectedTouroperatorId = NULL;
		
		$id = $this->getId();
		if($id) {
			$entity = $this->findById($id);
			$selectedTouroperatorId = $entity->touroperator()->id();
		} else {
			$selectedTouroperatorId = empty($touroperators) ? NULL : $touroperators[0]->id();
		}
		
		$this->state = new DesignerPageState($id, $touroperators, $selectedTouroperatorId);
	}
	
	public function template() : string {
		return 'designer/designer.html';
	}
	
	public function context() : array {
		return [
			'id' => $this->state->id(),
			'touroperators' => $this->state->touroperators(),
			'selectedTouroperatorId' => $this->state->selectedTouroperatorId()
		];
	}

	private function findById($id) {
        $entity = $this->context->ticketTemplateService()->findById($id);
        if($entity) {
            return $entity;
        }
        $this->context->router()->notFound();
    }

	private function getId() {
        $id = end(explode('/', getenv('REQUEST_URI')));
        return $id === 'designer' ? NULL : $id;
    }
}

class DesignerPageState {

	private $id;
	private $touroperators;
	private $selectedTouroperatorId;

	function __construct($id, $touroperators, $selectedTouroperatorId) {
		$this->id = $id;
		$this->touroperators = $touroperators;
		$this->selectedTouroperatorId = $selectedTouroperatorId;
	}

	public function id() {
		return $this->id;
	}

	public function touroperators() : Array {
		return $this->touroperators;
	}

	public function selectedTouroperatorId() {
		return $this->selectedTouroperatorId;
	}
}
?>