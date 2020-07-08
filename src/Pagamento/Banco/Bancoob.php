<?php

namespace Murilo\Pagamento\Pagamento\Banco;

use Murilo\Pagamento\Contracts\Pagamento\Pagamento as PagamentoContract;
use Murilo\Pagamento\Pagamento\AbstractPagamento;

/**
 * Class Sicoob
 * @package Murilo\Pagamento\Boleto\Banco
 */
class Bancoob extends AbstractPagamento implements PagamentoContract
{
    const INCLUSAO_REGISTRO_LIBERADO = '00';
    const EXCLUSAO_REGISTRO_INCLUIDO = '99';

    /**
     * Sicredi constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    /**
     * @return mixed|string
     */
    public function getInstrucaoMovimento()
    {
        if ($this->getTipoMovimento() === PagamentoContract::TIPO_MOVIMENTO_EXCLUSAO)
            return self::EXCLUSAO_REGISTRO_INCLUIDO;

        return self::INCLUSAO_REGISTRO_LIBERADO;
    }

}
