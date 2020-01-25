<?php

namespace Murilo\Pagamento\Cnab\Retorno\Cnab240;

use Carbon\Carbon;
use Murilo\Pagamento\Contracts\Cnab\Retorno\Cnab240\HeaderLote as HeaderLoteContract;
use Murilo\Pagamento\Traits\MagicTrait;

/**
 * Class HeaderLote
 * @package Murilo\Pagamento\Cnab\Retorno\Cnab240
 */
class HeaderLote implements HeaderLoteContract
{
    use MagicTrait;
    /**
     * @var string
     */
    protected $codBanco;

    /**
     * @var string
     */
    protected $numeroLoteRetorno;

    /**
     * @var string
     */
    protected $tipoRegistro;

    /**
     * @var string
     */
    protected $tipoOperacao;

    /**
     * @var string
     */
    protected $tipoServico;

    /**
     * @var string
     */
    protected $versaoLayoutLote;

    /**
     * @var string
     */
    protected $tipoInscricao;

    /**
     * @var string
     */
    protected $numeroInscricao;

    /**
     * @var string
     */
    protected $agenciaDv;


    /**
     * @var string
     */
    protected $nomeEmpresa;

    /**
     * @var string
     */
    protected $agencia;

    /**
     * @var string
     */
    protected $conta;

    /**
     * @var string
     */
    protected $contaDv;

    /**
     * @var string
     */
    protected $convenio;

    /**
     * @return string
     */
    public function getTipoRegistro()
    {
        return $this->tipoRegistro;
    }

    /**
     * @param string $tipoRegistro
     *
     * @return $this
     */
    public function setTipoRegistro($tipoRegistro)
    {
        $this->tipoRegistro = $tipoRegistro;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * @param string $codBanco
     *
     * @return $this
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroLoteRetorno()
    {
        return $this->numeroLoteRetorno;
    }

    /**
     * @param string $numeroLoteRetorno
     *
     * @return $this
     */
    public function setNumeroLoteRetorno($numeroLoteRetorno)
    {
        $this->numeroLoteRetorno = $numeroLoteRetorno;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipoOperacao()
    {
        return $this->tipoOperacao;
    }

    /**
     *
     * @param string $tipoOperacao
     * @return $this
     */
    public function setTipoOperacao($tipoOperacao)
    {
        $this->tipoOperacao = $tipoOperacao;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipoServico()
    {
        return $this->tipoServico;
    }

    /**
     * @param string $tipoServico
     *
     * @return $this
     */
    public function setTipoServico($tipoServico)
    {
        $this->tipoServico = $tipoServico;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersaoLayoutLote()
    {
        return $this->versaoLayoutLote;
    }

    /**
     * @param string $versaoLayoutLote
     *
     * @return $this
     */
    public function setVersaoLayoutLote($versaoLayoutLote)
    {
        $this->versaoLayoutLote = $versaoLayoutLote;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipoInscricao()
    {
        return $this->tipoInscricao;
    }

    /**
     *
     * @param $tipoInscricao
     *
     * @return $this
     */
    public function setTipoInscricao($tipoInscricao)
    {
        $this->tipoInscricao = $tipoInscricao;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroInscricao()
    {
        return $this->numeroInscricao;
    }

    /**
     * @param string $numeroInscricao
     *
     * @return $this
     */
    public function setNumeroInscricao($numeroInscricao)
    {
        $this->numeroInscricao = $numeroInscricao;

        return $this;
    }

    /**
     * @return string
     */
    public function getConvenio()
    {
        return $this->convenio;
    }

    /**
     * @param string $convenio
     *
     * @return $this
     */
    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;

        return $this;
    }

    /**
     * @return string
     */
    public function getNomeEmpresa()
    {
        return $this->nomeEmpresa;
    }

    /**
     * @param string $nomeEmpresa
     *
     * @return $this
     */
    public function setNomeEmpresa($nomeEmpresa)
    {
        $this->nomeEmpresa = $nomeEmpresa;

        return $this;
    }

    /**
     * @return string
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * @param string $agencia
     *
     * @return $this
     */
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;

        return $this;
    }

    /**
     * @return string
     */
    public function getAgenciaDv()
    {
        return $this->agenciaDv;
    }

    /**
     * @param string $agenciaDv
     *
     * @return $this
     */
    public function setAgenciaDv($agenciaDv)
    {
        $this->agenciaDv = $agenciaDv;

        return $this;
    }

    /**
     * @return string
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * @param string $conta
     *
     * @return $this
     */
    public function setConta($conta)
    {
        $this->conta = $conta;

        return $this;
    }

    /**
     * @return string
     */
    public function getContaDv()
    {
        return $this->contaDv;
    }

    /**
     * @param string $contaDv
     *
     * @return $this
     */
    public function setContaDv($contaDv)
    {
        $this->contaDv = $contaDv;

        return $this;
    }
}
