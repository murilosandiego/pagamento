<?php

namespace Murilo\Pagamento\Contracts\Pagamento;

use Carbon\Carbon;
use Murilo\Pagamento\Contracts\Pessoa as PessoaContract;

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

    public function getBanco();

    public function getAgencia();

    public function getAgenciaDv();

    public function getTipoMovimento();

    public function getInstrucaoMovimento();

    public function getTipoMoeda();

    public function getFinalidade();

    public function getFinalidadesTED();

    /**
     * @return PessoaContract
     */
    public function getFavorecido();

    public function getConta();

    public function getContaDv();

    public function getNumeroDocumento();

    /**
     * @return Carbon
     */
    public function getData();

    public function getValor();

}
