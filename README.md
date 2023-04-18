## Einführung

Der Seite [halbanalog.info](https://www.halbanalog.info) liegt das Konzept einer einfachen Photo Sharing Site zugrunde.

Der Name halbanalog bezieht sich auf die Ursprungsidee, eine Plattform für digitalisierte anloge Fotografie zu schaffen. Die vorliegenden Demo-Aufnahmen sind allerdings bereits im Urspung digital entstanden.

## Konzeption

> Ausgangspunkt waren folgende konzeptionelle Grundgedanken:

Die Nutzerarchitektur differenziert zwischen Besucher:innen, registrierten und aktiven Nutzer:innen sowie den Administrator:innen

- Die Nutzer:innenarchtiektur weist diesen Gruppen entsprechende Rechte, Bedienelemente und Zugriffsmöglichkeiten zu.

- Registrierte Nutzer:innen erhalten einen eigenen Bereich, sind aber nicht sichtbar

- Bildmedien von aktiven Nutzer:innen sind bis zur Freischaltung durch Administrator:innen nur für diese selbst sichtbar

Die Speicherung der geposteten Bildmedien erfolgt in der Datenbank.

- Die Ausgabe der Bildmedien nach Bildauflösung und -qualität erfolgt kontextbezogen und nach Nutzerstatus.

- Bildmedien werden clientseitig in der erforderlichen Bildauflösung aufgerufen, ein anschließendes Rendern im Browser entfällt.

Die Konfigurationsdatei setzt server- wie clientseitig gleichlautende Parameter.

- Javascipt wird kontextbezogen generiert

## Beschreibung

In der vorliegenden [Demo-Version](https://www.halbanalog.info) existieren fünf aktive Nutzer:innen - Paris, Rom, Siena, Florenz, Prag - sowie ein:e lediglich registrierte:r Nutzer:in - Wien.

- Name und Passwort ergeben sich nach dem selben Schema und sind jeweils der kleingeschriebene Stadtname -> Paris: paris/paris

- paris hat zusätzlich Administrator:innen-Rechte.

## zugrundeliegende

<p align="left"> <a href="https://getbootstrap.com" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/bootstrap/bootstrap-plain-wordmark.svg" alt="bootstrap" width="40" height="40"/> </a> </p>
<p align="left"> <a href="https://www.w3.org/html/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/html5/html5-original-wordmark.svg" alt="html5" width="40" height="40"/> </a> </p>
<p align="left"> <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/javascript/javascript-original.svg" alt="javascript" width="40" height="40"/> </a> </p>
<p align="left"> <a href="https://www.mysql.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/mysql/mysql-original-wordmark.svg" alt="mysql" width="40" height="40"/> </a> </p>
<p align="left"> <a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/> </a> </p>
