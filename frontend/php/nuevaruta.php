<?php

$ch = curl_init('http://localhost:8080/rutas/crear');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$result_php = json_decode($result, true);
echo $result;

/*
idtour:
idpaquete:
idtransporte:
c_dias:
c_noches:
precio:
pos:
*/
?>