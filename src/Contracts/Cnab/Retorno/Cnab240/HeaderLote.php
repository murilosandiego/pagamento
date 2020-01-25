<?php

namespace Murilo\Pagamento\Contracts\Cnab\Retorno\Cnab240;

interface HeaderLote
{
    /**
     * @return mixed
     */
    public function getTipoRegistro();

    /**
     * @return mixed
     */
    public function getTipoOperacao();

    /**
     * @return mixed
     */
    public function getTipoServico();

    /**
     * @return mixed
     */
    public function getVersaoLayoutLote();

    /**
     * @return mixed
     */
    public function getCodBanco();

    /**
     * @return mixed
     */
    public function getTipoInscricao();

    /**
     * @return mixed
     */
    public function getNumeroInscricao();

    /**
     * @return mixed
     */
    public function getNumeroLoteRetorno();

    /**
     * @return mixed
     */
    public function getConvenio();

    /**
     * @return mixed
     */
    public function getNomeEmpresa();

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
    public function getConta();

    /**
     * @return mixed
     */
    public function getContaDv();

    /**
     * @return array
     */
    public function toArray();
}
