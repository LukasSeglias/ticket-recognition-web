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
		
		echo "TOURCODE: ".$result->{'data'}->{'tourcode'};
		if(!isset($result->{'data'}) || !isset($result->{'data'}->{'tourcode'}) || !isset($result->{'templateKey'})) {
			return NULL;
		}
		$tourcode = $result->{'data'}->{'tourcode'};
		$templateKey = $result->{'templateKey'};

		echo "Tourcode: " . $tourcode . " Templatekey: " . $templateKey;

		$tours = $this->tourRepository->findBy($tourcode, NULL);
		$templates = $this->ticketTemplateService->findBy($templateKey);

		if(empty($tour) || empty($template)) {
			return NULL;
		}
		$tour = $tours[0];
		$template = $templates[0];

		$ticketTemplateId = $template->id();
		$tourId = $tour->id();
		$ticketId = $this->ticketRepository->create($ticketTemplateId, $tourId);

		return $this->ticketRepository->findById($ticketId);
	}
}

?>