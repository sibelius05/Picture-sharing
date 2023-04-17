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
   <span style="font-family: helvetica;">Hallo ' . $firstname . ' '  . $lastname . ',</span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style">
   <span style="font-family: helvetica;">vielen Dank, dass Du Dich bei halbanalog.de registriert hast.</span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style">
   <span style="font-family: helvetica;">Zu Deiner Registrierung hast Du die folgenden Angaben gemacht:</span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style" style="padding-left: 40px;">
   <span style="font-family: helvetica;"><strong>Name:</strong> ' . $firstname . ' '  . $lastname . '<br><strong>Geburtsdatum:</strong> '  . utf8_encode($var['birthday']) . '<br><strong>Geschlecht:</strong> '  . utf8_encode($var['gender']) . '<br><strong>Email:</strong> '  . $email . '<br><strong>Benutzername:</strong> '  . utf8_encode($var['username']) . '<br></span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style">
   <span style="font-family: helvetica;">Dein vorläufiges automatisch erstelltes Passwort lautet:</span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style" style="padding-left: 40px;">
   <span style="font-family: helvetica;"><strong>'  . $var['password'] . '</strong></span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style">
   <span style="font-family: helvetica;">Unter Deinem Benutzernamen und dem vorläufigen Passwort kannst Du Deine Angaben bearbeiten und erhältst alle Informationen zum Fortlauf Deiner Registrierung.</span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style">
   <span style="font-family: helvetica;">Zur abschließenden Aktivierung Deines Accounts schicken wir Dir in Kürze eine weitere Mail.</span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style">
   <span style="font-family: helvetica;">Herzliche Grüße</span>
  </div>
  <div class="default-style">
   &nbsp;
  </div>
  <div class="default-style">
   <span style="font-family: helvetica;">www.halbanalog.de</span>
  </div>
 </body>
</html>');