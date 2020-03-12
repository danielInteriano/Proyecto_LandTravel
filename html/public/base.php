<?php


require_once '../../vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('../templates');
$twig = new Environment($loader);
$words = ['sky', 'mountain', 'falcon', 'forest', 'rock', 'blue'];
$sentence = 'today is a windy day';

$ch = curl_init('http://localhost:8080/paises');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$paises = json_decode($result, true);
curl_close($ch);

echo $twig->render('content.html.twig', ['paises' => $paises, 'debug' => var_dump($paises['paises'][0])]);
?>