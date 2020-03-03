<?php

$ch = curl_init('localhost:8080/auth/lost');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$result_php = json_decode($result, true);
if(isset($result_php['message']))
{
    echo json_encode($result);
}else{
    echo json_encode($result);
}

?>