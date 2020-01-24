<?php

namespace Murilo\Pagamento\Contracts\Cnab;

use Murilo\Pagamento\Support\Collection;

interface RetornoCnab240 extends Cnab
{
    /**
     * @return mixed
     */
    public function getCodigoBanco();

    /**
     * @return mixed
     */
    public function getBancoNome();

    /**
     * @return Collection
     */
    public function getDetalhes();

    /**
     * @return Retorno\Cnab240\Detalhe
     */
    public function getDetalhe($i);

    /**
     * @return Retorno\Cnab240\Header
     */
    public function getHeader();

    /**
     * @return Retorno\Cnab240\HeaderLote
     */
    public function getHeaderLote();

    /**
     * @return Retorno\Cnab240\TrailerLote
     */
    public function getTrailerLote();

    /**
     * @return Retorno\Cnab240\Trailer
     */
    public function getTrailer();

    /**
     * @return string
     */
    public function processar();

    /**
     * @return array
     */
    public function toArray();
}
