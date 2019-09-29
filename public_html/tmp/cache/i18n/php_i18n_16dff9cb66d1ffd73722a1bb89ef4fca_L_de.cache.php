<?php class L {
const greeting = 'Hallo meine liebe Welt!';
const navigation_brand = 'CTI';
const navigation_designer = 'Designer';
const navigation_tickets = 'Tickets';
const navigation_tours = 'Touren';
const navigation_ticketpositions = 'Ticketpositionen';
const navigation_logout = 'Abmelden';
const login_title = 'Anmelden';
const login_email_label = 'E-Mail';
const login_email_placeholder = 'E-Mail';
const login_password_label = 'Passwort';
const login_password_placeholder = 'Passwort';
const login_submit = 'Anmelden';
const login_reset = 'Zurücksetzen';
const ticket_title = 'Ticket %s';
const ticket_touroperator_label = 'Touroperator';
const ticket_touroperator_placeholder = 'Touroperator';
const ticket_tourcode_label = 'Tourcode';
const ticket_tourcode_placeholder = 'Tourcode';
const ticket_date_label = 'Datum';
const ticket_date_placeholder = 'Datum';
const ticketpositions_title = 'Ticketpositionen';
public static function __callStatic($string, $args) {
    return vsprintf(constant("self::" . $string), $args);
}
}
function L($string, $args=NULL) {
    $return = constant("L::".$string);
    return $args ? vsprintf($return,$args) : $return;
}