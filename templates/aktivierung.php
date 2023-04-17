<?php
$text = $text ?? '';

$var = $var ?? [];

$text .= quoted_printable_encode('<!doctype html>
<html>
 <head>
  <meta charset="UTF-8">
 </head>
 <body>
  <div class="default-style">
   <div class="default-style">
    <span style="font-family: helvetica;">Hallo ' . $firstname . ' '  . $lastname . ',</span>
   </div>
   <div class="default-style">
    &nbsp;
   </div>
   <div class="default-style">
    <span style="font-family: helvetica;">vielen Dank für Deine Registrierung bei halbanalog.de.</span>
   </div>
   <div class="default-style">
    &nbsp;
   </div>
   <div class="default-style">
    <span style="font-family: helvetica;">Zur Aktivierung Deines Accounts klicke bitte auf <a href="https://www.halbanalog.info/'  . $var['link'] . '">www.halbanalog.info/'  . substr($var['link'], 0, '15') . '...</a></span><span style="font-family: helvetica;">. Das ist alles.</span>
   </div>
   <div class="default-style">
    &nbsp;
   </div>
   <div class="default-style">
    <span style="font-family: helvetica;">Anschließend musst Du noch ein neues Passwort wählen und kannst dann sofort loslegen.</span>
   </div>
   <div class="default-style">
    &nbsp;
   </div>
   <div class="default-style">
    <span style="font-family: helvetica;">Viel Spaß.</span>
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
  </div>
 </body>
</html>');