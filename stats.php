<?php
  function countFeeder() {
    $feederjson = file_get_contents('./feeder.json');
    $feeder = json_decode($feederjson);

    return count($feeder);
  }
  function countFind() {
    $nbfind = file_get_contents('nbfind.txt');
    return $nbfind;
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>OVH Disponibilité - STATS</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <link rel="stylesheet" href="./components/bootstrap/dist/css/bootstrap.min.css" media="screen">
  <link rel="stylesheet" href="./css/style.css" media="screen">
</head>
<body>
  <div class="container">
    <div class="col-md-6">
      <canvas id="userWait" width="400" height="400"></canvas>
    </div>
    <div class="col-md-6">

    </div>
    <p> Il y a <?= countFeeder(); ?> inscrits</p>
    <p> Il y a <?= countFind(); ?> personnes qui ont étés servis</p>
  </div>
  <script src="./components/jquery/dist/jquery.min.js"></script>
  <script src="./components/Chart.js/Chart.min.js"></script>
  <script src="./components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="./js/script.js"></script>
</body>
</html>
