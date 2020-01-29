<?php

namespace Murilo\Pagamento\Contracts\Pagamento;

use Carbon\Carbon;
use Murilo\Pagamento\Contracts\Pessoa as PessoaContract;

/**
 * Interface Pagamento
 * @package Murilo\Pagamento\Contracts\Pagamento
 */
interface Pagamento
{
    const COD_BANCO_BB = '001';
    const COD_BANCO_SANTANDER = '033';
    const COD_BANCO_CEF = '104';
    const COD_BANCO_BRADESCO = '237';
    const COD_BANCO_ITAU = '341';
    const COD_BANCO_HSBC = '399';
    const COD_BANCO_SICREDI = '748';
    const COD_BANCO_BANRISUL = '041';
    const COD_BANCO_BANCOOB = '756';
    const COD_BANCO_BNB = '004';

    const TIPO_MOVIMENTO_INCLUSAO = 0;
    const TIPO_MOVIMENTO_ALTERACAO = 5;
    const TIPO_MOVIMENTO_EXCLUSAO = 3;

    /**
     * @return mixed
     */
    public function getBanco();

    /**
     * @return mixed
     */
    public function getAgencia();

    /**
     * @return mixed
     */
    public function getAgenciaDv();

    /**
     * @return mixed
     */
    public function getTipoMovimento();

    /**
     * @return mixed
     */
    public function getInstrucaoMovimento();

    /**
     * @return mixed
     */
    public function getTipoMoeda();

    /**
     * @return mixed
     */
    public function getFinalidade();

    /**
     * @return mixed
     */
    public function getFinalidadesTED();

    /**
     * @return PessoaContract
     */
    public function getFavorecido();

    /**
     * @return mixed
     */
    public function getConta();

    /**
     * @return mixed
     */
    public function getContaDv();

    /**
     * @return mixed
     */
    public function getNumeroDocumento();

    /**
     * @return Carbon
     */
    public function getData();

    /**
     * @return mixed
     */
    public function getValor();

}
