<?php

require 'vendor/autoload.php';

use Marcus\BuscadorDeTabuas\Buscador;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$client = new Client(['base_uri' => 'https://tabuademares.com/']);
$crawler = new Crawler();

$buscador = new Buscador($client, $crawler);
$tabuas = $buscador->buscar('/br/paraiba/joao-pessoa/previsao/mares');

echo exibeMensagem($tabuas);