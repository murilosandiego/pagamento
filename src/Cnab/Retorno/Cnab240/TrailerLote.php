<?php

namespace Murilo\Pagamento\Cnab\Retorno\Cnab240;

use Murilo\Pagamento\Contracts\Cnab\Retorno\Cnab240\TrailerLote as TrailerLoteContract;
use Murilo\Pagamento\Traits\MagicTrait;

/**
 * Class TrailerLote
 * @package Murilo\Pagamento\Cnab\Retorno\Cnab240
 */
class TrailerLote implements TrailerLoteContract
{
    use MagicTrait;
    /**
     * @var integer
     */
    protected $loteServico;

    /**
     * @var integer
     */
    protected $TipoRegistro;

    /**
     * @var integer
     */
    protected $qtdRegistroLote;

    /**
     * @var float
     */
    protected $valorTotalTitulos;

    /**
     * @return mixed
     */
    public function getLoteServico()
    {
        return $this->loteServico;
    }

    /**
     * @param mixed $loteServico
     *
     * @return $this
     */
    public function setLoteServico($loteServico)
    {
        $this->loteServico = $loteServico;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtdRegistroLote()
    {
        return $this->qtdRegistroLote;
    }

    /**
     * @param mixed $qtdRegistroLote
     *
     * @return $this
     */
    public function setQtdRegistroLote($qtdRegistroLote)
    {
        $this->qtdRegistroLote = $qtdRegistroLote;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getTipoRegistro()
    {
        return $this->TipoRegistro;
    }

    /**
     * @param mixed $TipoRegistro
     *
     * @return $this
     */
    public function setTipoRegistro($TipoRegistro)
    {
        $this->TipoRegistro = $TipoRegistro;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValorTotalTitulos()
    {
        return $this->valorTotalTitulos;
    }

    /**
     * @param mixed $valorTotalTitulos
     *
     * @return $this
     */
    public function setValorTotalTitulos($valorTotalTitulos)
    {
        $this->valorTotalTitulos = $valorTotalTitulos;

        return $this;
    }
}
