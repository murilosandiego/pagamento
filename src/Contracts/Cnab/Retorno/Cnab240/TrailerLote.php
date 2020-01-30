<?php

namespace Murilo\Pagamento\Contracts\Cnab\Retorno\Cnab240;

interface TrailerLote
{
    /**
     * @return mixed
     */
    public function getLoteServico();

    /**
     * @return mixed
     */
    public function getQtdRegistroLote();

    /**
     * @return mixed
     */
    public function getTipoRegistro();

    /**
     * @return mixed
     */
    public function getValorTotalTitulos();

    /**
     * @return array
     */
    public function toArray();
}
