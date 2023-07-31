<?php

namespace Marcus\BuscadorDeTabuas;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private $httpClient;
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {
        $resposta = $this->httpClient->request('GET', $url);

        $html = $resposta->getBody();

        $this->crawler->addHtmlContent($html);

        $tabuas = [];

        $fichas = $this->crawler->filter('table.f_tabla_mareas')->first();
        foreach ($fichas as $ficha) {
            $trs =  $ficha->childNodes;
            $trsSelecionadas = [];
            $i = 0;
            foreach ($trs as $tr) {
                if ($i > 0) {
                    $trsSelecionadas[] = $tr;
                }
                $i++;
            }

            $tabuas = [];

            $tabua = [];
            foreach ($trsSelecionadas as $trs) {
                $filhos = $trs->childNodes;

                // Verifica se $filhos é diferente de null antes de acessar suas propriedades
                if ($filhos && $filhos->item(1) && $filhos->item(2)) {
                    $tabua = [];

                    $tabua['hora'] = $filhos->item(1)->textContent;
                    $tabua['altura'] = $filhos->item(2)->textContent;

                    $tabuas[] = $tabua;
                }
            }
        }

        return $tabuas;
    }
}
