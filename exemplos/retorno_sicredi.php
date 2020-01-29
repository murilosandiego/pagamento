<?php
require 'autoload.php';

$path = realpath(__DIR__ . '/arquivos/1TVQ23011037.RET');
$retorno = \Murilo\Pagamento\Cnab\Retorno\Factory::make($path);

//echo $retorno->getBancoNome() . PHP_EOL . PHP_EOL;

foreach($retorno as $registro) {
    var_dump($registro->toArray());
}