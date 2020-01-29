<?php
namespace Murilo\Pagamento\Contracts;

/**
 * Interface Pessoa
 * @package Murilo\Pagamento\Contracts
 */
interface Pessoa
{
    /**
     * @return mixed
     */
    public function getNome();

    /**
     * @return mixed
     */
    public function getNomeDocumento();

    /**
     * @return mixed
     */
    public function getDocumento();

    /**
     * @return mixed
     */
    public function getBairro();

    /**
     * @return mixed
     */
    public function getEndereco();

    /**
     * @return mixed
     */
    public function getNumero();

    /**
     * @return mixed
     */
    public function getComplemento();

    /**
     * @return mixed
     */
    public function getCepCidadeUf();

    /**
     * @return mixed
     */
    public function getCep();

    /**
     * @return mixed
     */
    public function getCidade();

    /**
     * @return mixed
     */
    public function getUf();

    /**
     * @return mixed
     */
    public function toArray();
}
