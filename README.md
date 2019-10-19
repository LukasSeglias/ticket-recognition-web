# Ticketrecognition Web
Small project developed as part of the module "Web Programming" at [Bern University of Applied Sciences BFH](https://www.bfh.ch) in 2019.

## Technology used
* Server: [PHP](https://www.php.net)
* Client: [JavaScript](https://developer.mozilla.org/de/docs/Web/JavaScript)
* HTTP-Server [Apache](https://httpd.apache.org/)
* Database [MySQL](https://www.mysql.com)
* Containerization: [Docker](https://www.docker.com/)
* CSS-Framework: [Bootstrap](http://getbootstrap.com)
* PHP dependency manager: [Composer](https://getcomposer.org/)
* PHP i18n: [php-i18n](https://github.com/Philipp15b/php-i18n)
* PHP template engine: [Twig](https://twig.symfony.com)
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

