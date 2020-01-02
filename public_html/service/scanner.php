<?php
namespace CTI;

require_once './model/message.php';

class ScannerService {

	private $ctiService;
	private $tourRepository;
	private $ticketRepository;
	private $ticketTemplateService;

	function __construct($ctiService, $tourRepository, $ticketRepository, $ticketTemplateService) {
		$this->ctiService = $ctiService;
		$this->tourRepository = $tourRepository;
		$this->ticketRepository = $ticketRepository;
		$this->ticketTemplateService = $ticketTemplateService;
	}

	function match($file) {
		
		$fileExtension = pathinfo($file['name'])['extension'];
		$result = $this->ctiService->match($file['tmp_name'], $fileExtension, $_COOKIE['ACCESS_TOKEN']);
		
		if(!isset($result->{'data'}) || !isset($result->{'data'}->{'tourcode'}) || !isset($result->{'templateKey'})) {
			return NULL;
		}
		$tourcode = $result->{'data'}->{'tourcode'};
		$templateKey = $result->{'templateKey'};

		$tours = $this->tourRepository->findBy($tourcode, NULL);
		$templates = $this->ticketTemplateService->findBy($templateKey);

		if(empty($tours) || empty($templates)) {
			return NULL;
		}
		$tour = $tours[0];
		$template = $templates[0];

		$ticketTemplateId = $template->id();
		$tourId = $tour->id();
		$ticketId = $this->ticketRepository->create($ticketTemplateId, $tourId);
		foreach($tour->tourpositions() as $tourposition) {
			$this->ticketRepository->addPosition($ticketId, $tourposition->description(), $tourposition->code());
		}

		return $this->ticketRepository->get($ticketId);
	}
}

?>