<?php

$ch = curl_init('http://34.94.254.221:8080/auth/login');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$result_php = json_decode($result, true);
if(isset($result_php['token']))
{
    setcookie("Key", $result_php['token'], NULL, NULL, NULL, NULL, TRUE);
    echo json_encode(['message' => 'Login exitoso', 'logged' => true]);
}else{
    echo json_encode(['message' => 'Credenciales invalidas', 'logged' => false]);
}
?>