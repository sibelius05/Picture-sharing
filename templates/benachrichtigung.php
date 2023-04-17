<?php

$text = $text ?? '';
$firstname = $firstname ?? '';
$lastname = $lastname ?? '';
$email = $email ?? '';

$var = $var ?? [];

$text .= quoted_printable_encode('<!doctype html>
<html>
 <head>
  <meta charset="UTF-8">
 </head>
 <body>
  <div class="default-style">
   <span style="font-family: helvetica;">Hallo ' . FIRSTNAME_ADMIN . ' '  . LASTNAME_ADMIN . ',</span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style">
   <span style="font-family: helvetica;">es liegt eine neue Registrierung vor.</span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style">
   <span style="font-family: helvetica;">Der Nutzer hat die folgenden Angaben gemacht:</span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style" style="padding-left: 40px;">
   <span style="font-family: helvetica;"><strong>Name:</strong> ' . $var['firstname'] . ' '  . $var['lastname'] . '<br><strong>Geburtsdatum:</strong> '  . $var['birthday'] . '<br><strong>Geschlecht:</strong> '  . $var['gender'] . '<br><strong>Email:</strong> '  . $email . '<br><strong>Benutzername:</strong> '  . $var['username'] . '<br></span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style">
   <span style="font-family: helvetica;">Bitte die Angaben überprüfen und den neuen Nutzer freischalten.</span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style">
   <span style="font-family: helvetica;">www.halbanalog.de</span>
  </div>
 </body>
</html>');