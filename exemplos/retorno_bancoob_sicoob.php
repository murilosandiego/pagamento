<?php
require 'autoload.php';

$path = realpath(__DIR__ . '/arquivos/PAG_756_146994_07072000.RET');
$retorno = \Murilo\Pagamento\Cnab\Retorno\Factory::make($path);

echo $retorno->getBancoNome() . PHP_EOL . PHP_EOL;

foreach($retorno as $registro) {
    var_dump($registro->toArray());
}