<?php
namespace CTI;
use \PDO;

require_once './bootstrap.php';

$path = $_SERVER['PATH_INFO'];

if($path === '/index.php') {

	// TODO: homepage

} elseif($path === '/tickets.php') {

	require_once './components/ticket/tickets.php';
	bootstrap('tickets', function ($context) {
		return new TicketSearchPage($context);
	});

} elseif($path === '/ticket_detail.php') {

	require_once './components/ticket/ticket_detail.php';
	bootstrap('tickets', function ($context) {
		return new TicketDetailPage($context);
	});

} else if($path === '/designs.php') {

	require_once './components/designer/designs.php';
	bootstrap('designs', function ($context) {
		return new DesignSearchPage($context);
	});

} elseif($path === '/tours.php') {

	require_once './components/tour/tours.php';
	bootstrap('tours', function ($context) {
		return new TourSearchPage($context);
	});

} elseif($path === '/ticketpositions.php') {

	require_once './components/ticketposition/ticketpositions.php';
	bootstrap('ticketpositions', function ($context) {
		return new TicketpositionSearchPage($context);
	});

} elseif($path === '/login.php') {

	require_once './components/login/login.php';
	bootstrap(NULL, function ($context) {
		return new LoginPage($context);
	});

} else {

	// TODO: NOT FOUND PAGE
}

$host = 'db';
$user = 'root';
$pass = 'rootpassword';

try {
   $dbh = new PDO('mysql:host=db;port=3306', $user, $pass);
   
} catch (PDOException $e) {
   print "Error!: " . $e->getMessage() . "<br/>";
   die();
}
?>