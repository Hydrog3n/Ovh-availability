<?php

if (isset($_POST['submit'])) {
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify?secret=6LcBpP8SAAAAADBGldR83V1J12pGt6Zkd51mN3zF&response=g-recaptcha-response',
  ));
  // Send the request & save response to $resp
  $resp = curl_exec($curl);
  // Close request to clear up some resources
  curl_close($curl);
  echo $resp;
  $servRef = $_POST['servRef'];
  $mail = $_POST['mail'];
  $feederjson = file_get_contents('./feeder.json');
  $feeder = json_decode($feederjson);
  $feeder[] = array ($servRef, $mail);
  $encoded_feeder = json_encode($feeder);

  if (file_put_contents('./feeder.json',$encoded_feeder.PHP_EOL)) {
    $log = true;
  } else {
    $log = false;
  }


}
  $serversjson = file_get_contents('./servers.json');
  $servers = json_decode($serversjson);

?>
<!DOCTYPE html>
<html>
  <head>
    <title>OVH Disponibilité</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" href="./components/bootstrap/dist/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="./css/style.css" media="screen">
  </head>
  <body>

    <div class="container">
      <?php
        if (isset($log) && $log === true) {
      ?>
          <div class="alert alert-success">
            <p> Enregistrement Réussi</p>
          </div>
          <?php
        } else if (isset($log) && $log === false)  {
          ?>
          <div class="alert alert-danger">
            <p> Erreur d'enregistrement, prevenir l'administrateur.</p>
          </div>
      <?php
        }
      ?>
      <div class="well well-lg">
        <p>Pour connaitre la disponibilité d'un des serveurs d'OVH (SoYourStart, Kimsufi, OVH) </p>
        <p>Selectionnez le serveur parmis la liste et ajouter votre mail (Utiliser juste pour vous envoyer un mail.)</p>
        <p>Une fois le mail envoyé, votre inscription est supprimée une fois le mail envoyé, un lien de renouvellement est disponible dans le mail si vous ratez la disponibilité.</p>
      </div>
      <div class="alert alert-danger">
        <p>Certainne adresse mail passe encore en spam. Surveillez donc votre dossier ou ajouté contact@loicvaille.ovh dans les contacts. <br> N'hésitez pas à me contactez en cas de problème.</p>
      </div>
      <form action="" method="post">
        <div class="form-group">
          <label for="server" class="">Liste des serveurs</label>
          <select id="server" name="servRef" class="form-control">
           <?php
            foreach ($servers as $server) {
              echo '<option value="'.$server->ref.'">'.$server->name.'</option>';
            }
           ?>
         </select>
        </div>
        <div class="form-group">
          <label for="mail">Adresse Mail</label>
          <input type="email" name="mail" id="mail" value="" placeholder="Votre Mail" class="form-control">
        </div>
        <div class="form-group">
          <div class="g-recaptcha" data-sitekey="6LcBpP8SAAAAANFhB6Y7ohj0P7xC_V-DAn1CmBOy"></div>
        </div>
        <div class="form-group">
          <button name="submit" class="btn btn-success">Valider</button>
        </div>
      </form>
    </div>



    <script src="./components/jquery/dist/jquery.min.js"></script>
    <script src="./components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </body>
</html>
