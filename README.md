# Ticketrecognition Web
Small project developed as part of the module "Web Programming" at [Bern University of Applied Sciences BFH](https://www.bfh.ch) in 2019.

## Technology used
* Server: [PHP](https://www.php.net)
* Client: [JavaScript](https://developer.mozilla.org/de/docs/Web/JavaScript)
* HTTP-Server: [Apache](https://httpd.apache.org/)
* Database: [PostgreSQL](https://www.postgresql.org/)
* Containerization: [Docker](https://www.docker.com/)
* CSS-Framework: [Bootstrap](http://getbootstrap.com)
* PHP dependency manager: [Composer](https://getcomposer.org/)
* PHP i18n: [php-i18n](https://github.com/Philipp15b/php-i18n)
* PHP template engine: [Twig](https://twig.symfony.com)
* Java EE application server: [Wildfly](https://wildfly.org/)
* Identity and Access Management: [Keycloak](https://www.keycloak.org/)
* Version control: [Git](https://git-scm.com/)

## Authors
* [Luca Ritz](https://github.com/LucaRitz)
* [Lukas Seglias](https://github.com/LukasSeglias)

## Troubleshooting
If for some reason you get a "File not found.", then it is likely that mounting the volumes to the docker containers did not work. On Windows 10, I regularly have to enter the following command in a PowerShell that I run as admin:
```
Set-NetConnectionProfile -interfacealias "vEthernet (DockerNAT)" -NetworkCategory Private
```
After that, in the Docker Desktop settings, disable and re-enable shared drives.

# Getting started
Go to http://jolaya.han-solo.net/

# Feature description
## Templates
* Search templates.
* Edit templates.
* Create new templates.

## Template Designer
* Upload template image
* Draw named text-sections.
* Edit and move named text-sections.

## Ticketscanner
* Upload image.
* Edit scanned information.
* Create Ticket based on the extracted information.

## Tickets
* Search tickets.
* Edit tickets.

## Tours
* Search tours.
* Edit tours.
* Create tour.

## Tourpositions
* Search tourpositions.
* Edit tourpositions.
* Create tourpositions.

## Touroperators
* Search touroperators.
* Create touroperator.
* Edit touroperators.

## Language
* Change language
