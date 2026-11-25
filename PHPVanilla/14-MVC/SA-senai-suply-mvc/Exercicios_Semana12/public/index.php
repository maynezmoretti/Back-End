<?php
declare(strict_types=1);

use App\Core\Roteador;
use App\Exercicios\Ex01RotaParametro;
use App\Exercicios\Ex02ControllerApi;
use App\Exercicios\Ex03MiddlewareLog;
use App\Exercicios\Ex04ExclusaoProduto;
use App\Exercicios\Ex05FiltroCatalogo;

require dirname(__DIR__) . '/vendor/autoload.php';

$roteador = new Roteador();

Ex01RotaParametro::registrar($roteador);
Ex02ControllerApi::registrar($roteador);
Ex03MiddlewareLog::registrar($roteador);
Ex04ExclusaoProduto::registrar($roteador);
Ex05FiltroCatalogo::registrar($roteador);

Ex03MiddlewareLog::registrar($roteador);

$roteador->executar();