<?php
  $ch = curl_init('localhost:8080/pais');
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);
  $paises = json_decode($result, true);
  echo $paises;
  curl_close($ch);