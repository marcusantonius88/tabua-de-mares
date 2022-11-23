<?php

namespace Marcus\BuscadorDeTabuas\Tests;

use Marcus\BuscadorDeTabuas\Buscador;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\DomCrawler\Crawler;

class TestBuscadorDeTabuas extends TestCase
{
    private $httpClientMock;
    private $url = 'url-teste';

    protected function setUp(): void
    {
        $html = <<<FIM
        <html>
            <body>
            <table class="f_tabla_mareas"><tbody><tr><th></th><th>Marés</th><th>Altura</th><th>Coef.</th></tr><tr class="azul"><td class="ico"><span class="icon-ficha_pleamar"></span></td><td>3:27</td><td><span class="tabla_mareas_marea_altura_numero">2,4</span> <span class="prevision_unidad">m</span></td><td>96</td></tr><tr class="rojo"><td class="ico"><span class="icon-ficha_bajamar"></span></td><td>9:35</td><td><span class="tabla_mareas_marea_altura_numero">0,2</span> <span class="prevision_unidad">m</span></td><td>96</td></tr><tr class="azul"><td class="ico"><span class="icon-ficha_pleamar"></span></td><td>15:45</td><td><span class="tabla_mareas_marea_altura_numero">2,4</span> <span class="prevision_unidad">m</span></td><td>96</td></tr><tr class="rojo"><td class="ico"><span class="icon-ficha_bajamar"></span></td><td>21:53</td><td><span class="tabla_mareas_marea_altura_numero">0,2</span> <span class="prevision_unidad">m</span></td><td>96</td></tr></tbody></table>
            </body>
        </html>
        FIM;


        $stream = $this->createMock(StreamInterface::class);
        $stream
            ->expects($this->once())
            ->method('__toString')
            ->willReturn($html);

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $httpClient = $this
            ->createMock(ClientInterface::class);
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', $this->url)
            ->willReturn($response);

        $this->httpClientMock = $httpClient;
    }

    public function testBuscadorDeveRetornarCursos()
    {
        $crawler = new Crawler();
        $buscador = new Buscador($this->httpClientMock, $crawler);
        $cursos = $buscador->buscar($this->url);

        var_dump($cursos);

        $this->isTrue();
        $this->assertCount(0, $cursos);
        //$this->assertEquals('Curso Teste 1', $cursos[0]);
        //$this->assertEquals('Curso Teste 2', $cursos[1]);
        //$this->assertEquals('Curso Teste 3', $cursos[2]);
    }
}