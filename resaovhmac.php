<?php
$feeder = getFeeder();

$getAvailability = file_get_contents("https://ws.ovh.com/dedicated/r2/ws.dispatcher/getAvailability");
// echo $getAvailability;
$availability = json_decode($getAvailability);

$servAvailability = $availability->answer->availability;

foreach ($servAvailability as $key => $value) {

   //echo $value->reference;
   foreach ($feeder as $feed) {
     if ($value->reference == $feed[0]) {
      $avaible = false;
       foreach ($value->zones as $zone) {
        // echo $zone->availability;
         if ($zone->availability != "unavailable") {
          // sendmail($zone, $feed[0], $feed[1]);
          $avaible = true;
         }
       }
       if ($avaible === true) {
         sendmail($feed[0], $feed[1]);
         //echo 'mailsend';
       }
     }
   }

}
// var_dump($availability);
function sendmail($servRef, $mailFeeder) {
  $to      = "$mailFeeder";
  $subject = 'Serveur Disponible';
  $message = "Le serveur ($servRef) est disponible.
Pour le réserver aller à ce lien  : https://eu.soyoustart.com/fr/commande/soYouStart.xml?reference=$servRef

Vous avez raté la disponibilité réactiver la demande : http://ovh-availability.loicvaille.ovh/";
  $headers = 'From: loic.vaille@gmail.com' . "\r\n" .
  'Reply-To: loic.vaille@gmail.com' . "\r\n" .
  'X-Mailer: PHP/' . phpversion();

  $log = mail($to, $subject, $message, $headers);

  if ($log === true ) {
    deleteFeeder($mailFeeder, $servRef);
    incressFind();
  }

}


function getFeeder() {
  $feederjson = file_get_contents('feeder.json');
  return json_decode($feederjson);
}

function deleteFeeder($mail, $servRef) {
  $feederjson = file_get_contents('feeder.json');
  $feeder = json_decode($feederjson);
  $newfeeder = array();
  foreach ($feeder as $user) {
    if ($mail != $user[1] || $servRef != $user[0]) {
      $newfeeder[] = $user;
    }
  }
  $encoded_feeder = json_encode($newfeeder);
  file_put_contents('feeder.json',$encoded_feeder.PHP_EOL);
}

function incressFind() {
  $file = fopen('./nbfind.txt', 'r+');

  $nbfind = fgets($file); // On lit la première ligne (nombre de pages vues)
  $nbfind = $nbfind + 1;

  fseek($file, 0); // On remet le curseur au début du fichier
  fputs($file, $nbfind); // On écrit le nouveau nombre de pages vues

  fclose($file);

}
