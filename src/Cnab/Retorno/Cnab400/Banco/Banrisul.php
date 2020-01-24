<?php
namespace Murilo\Pagamento\Cnab\Retorno\Cnab400\Banco;

use Murilo\Pagamento\Cnab\Retorno\Cnab400\AbstractRetorno;
use Murilo\Pagamento\Contracts\Boleto\Boleto as BoletoContract;
use Murilo\Pagamento\Contracts\Cnab\RetornoCnab400;

/**
 * Class Banrisul
 * @package Murilo\Pagamento\Cnab\Retorno\Cnab400\Banco
 */
class Banrisul extends AbstractRetorno implements RetornoCnab400
{
    /**
     * Código do banco
     *
     * @var string
     */
    protected $codigoBanco = BoletoContract::COD_BANCO_BANRISUL;

    /**
     * @param array $header
     * @return bool
     */
    protected function processarHeader(array $header)
    {
        return true;
    }

    /**
     * @param array $detalhe
     * @return bool
     */
    protected function processarDetalhe(array $detalhe)
    {
        return true;
    }

    /**
     * @param array $trailer
     * @return bool
     */
    protected function processarTrailer(array $trailer)
    {
        return true;
    }
}
