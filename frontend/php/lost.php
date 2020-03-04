<?php

$ch = curl_init('localhost:8080/auth/codigoRespaldo');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$result_php = json_decode($result, true);
echo $result;

?>